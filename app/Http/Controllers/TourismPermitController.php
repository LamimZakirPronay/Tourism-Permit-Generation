<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permit;
use App\Models\TourGuide;
use App\Models\TeamMember;
use App\Models\SiteSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Area;        // <--- ADD THIS LINE (This fixes the error)
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB; // <--- ADD THIS LINE
class TourismPermitController extends Controller
{
    /**
     * Display a listing of the permits.
     */
    public function index(Request $request)
    {
        $query = Permit::query();

        if ($request->filled('departure_date')) {
            $query->whereDate('departure_datetime', $request->departure_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $permits = $query->latest('departure_datetime')->paginate(10);
        return view('admin.permit.index', compact('permits'));
    }

    public function markAsExited($id)
    {
        $permit = Permit::findOrFail($id);
        $permit->update(['status' => 'completed']);

        return back()->with('success', 'The group ' . $permit->group_name . ' has been marked as exited.');
    }

    public function show($id)
    {
        $permit = Permit::with(['teamMembers', 'tourGuide'])->findOrFail($id);
        return view('admin.permit.show', compact('permit'));
    }

    public function create()
    {
        $guides = TourGuide::where('is_active', true)->get();
        $areas = Area::where('is_active', true)->orderBy('name', 'asc')->get();        // Fetch the dynamic adult fee from settings
        $adultFee = SiteSetting::where('key', 'permit_fee')->value('value') ?? 50.00;
        
        return view('permit.create', compact('areas','guides', 'adultFee'));
    }

    /**
     * Store a newly created permit in storage.
     */public function store(Request $request)
{
    $validatedData = $request->validate([
        'group_name'                => 'required|string|max:255',
        'leader_name'               => 'required|string|max:255',
        'leader_nid'                => 'required|string',
        'is_defense'                => 'nullable|boolean', // Added defense validation
        'email'                     => 'required|email',
        'contact_number'            => 'required|string',
        // Area Multi-select validation
        'area_ids'                  => 'required|array|min:1',
        'area_ids.*'                => 'exists:areas,id',
        'tour_guide_id'             => 'required|exists:tour_guides,id',
        'document'                  => 'required|mimes:pdf|max:5120',
        'arrival_datetime'          => 'required|date',
        'departure_datetime'        => [
            'required', 
            'date', 
            'after:arrival_datetime',
            function ($attribute, $value, $fail) {
                $time = \Carbon\Carbon::parse($value)->format('H:i');
                if ($time > '17:00') {
                    $fail('The departure time cannot be later than 5:00 PM.');
                }
            },
        ],
        'vehicle_ownership'         => 'required|string',
        'vehicle_reg_no'            => 'required|string',
        'driver_name'               => 'required|string',
        'driver_contact'            => 'required|string',
        'driver_emergency_contact'  => 'nullable|string',
        'driver_blood_group'        => 'nullable|string',
        'driver_license_no'         => 'required|string',
        'driver_nid'                => 'required|string',
        'team'                      => 'required|array|min:1',
        'team.*.name'               => 'required|string',
        'team.*.fathers_name'       => 'required|string',
        'team.*.age'                => 'required|integer|min:0',
        'team.*.gender'             => 'required|string|in:Male,Female,Other',
        'team.*.age_category'       => 'required|string|in:Adult,Children,Infant',
        'team.*.address'            => 'required|string',
        'team.*.profession'         => 'required|string',
        'team.*.contact_number'     => 'required|string',
        'team.*.emergency_contact'  => 'required|string',
        'team.*.blood_group'        => 'required|string',
        'team.*.id'                 => 'required|string', 
    ]);

    // Fetch Unit Fee from Settings
    $unitFee = \App\Models\SiteSetting::where('key', 'permit_fee')->value('value') ?? 50.00;

    // DEFENSE LOGIC: If leader is defense personnel, charge only for 1 person.
    // Otherwise, charge for all adults in the team.
    if ($request->has('is_defense') && $request->is_defense == 1) {
        $totalAmount = $unitFee;
    } else {
        $adultCount = collect($request->team)->where('age_category', 'Adult')->count();
        $totalAmount = $unitFee * $adultCount;
    }

    return \DB::transaction(function () use ($request, $validatedData, $totalAmount) {
        
        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('permits', 'public');
            $validatedData['document_path'] = $path;
        }

        // Exclude 'team' and 'area_ids' from Permit table insert
        $insertData = collect($validatedData)->except(['team', 'area_ids'])->toArray();
        $insertData['is_defense'] = $request->has('is_defense') ? 1 : 0; // Explicitly save the boolean status
        $insertData['arrival_datetime'] = \Carbon\Carbon::parse($request->arrival_datetime)->toDateTimeString();
        $insertData['departure_datetime'] = \Carbon\Carbon::parse($request->departure_datetime)->toDateTimeString();
        $insertData['total_members'] = count($request->team);
        $insertData['amount'] = $totalAmount;
        $insertData['payment_status'] = 1; 
        $insertData['bkash_trx_id'] = 'SIM_TRX_' . strtoupper(bin2hex(random_bytes(4)));
        $insertData['bkash_payment_id'] = 'BK_SIM_' . time();

        // 1. Create Permit
        $permit = \App\Models\Permit::create($insertData);

        // 2. Attach Many-to-Many Areas
        $permit->areas()->attach($request->area_ids);

        // 3. Create Team Members
        foreach ($request->team as $memberData) {
            $permit->teamMembers()->create([
                'name'              => $memberData['name'],
                'fathers_name'      => $memberData['fathers_name'],
                'age'               => $memberData['age'],
                'gender'            => $memberData['gender'],
                'age_category'      => $memberData['age_category'],
                'address'           => $memberData['address'],
                'profession'        => $memberData['profession'],
                'contact_number'    => $memberData['contact_number'],
                'emergency_contact' => $memberData['emergency_contact'],
                'blood_group'       => $memberData['blood_group'],
                'nid_or_passport'   => $memberData['id'],
            ]);
        }

        return $this->generatePermitPDF($permit);
    });
}
    private function generatePermitPDF(Permit $permit)
    {
        $permit->refresh(); 
        $permit->load(['tourGuide', 'teamMembers']);
        
        $settings = SiteSetting::pluck('value', 'key');
        $verifyUrl = route('permit.verify', $permit->id);

        $qrCode = base64_encode(QrCode::format('svg')
            ->size(150)->errorCorrection('H')->margin(1)->generate($verifyUrl));
        
        $data = [
            'permit'       => $permit,
            'instructions' => $settings['permit_instructions'] ?? 'Default instructions...',
            'contacts'     => $settings['emergency_contacts'] ?? 'Default contacts...',
            'qrCode'       => $qrCode, 
            'title'        => 'Restricted Area Entry Permit',
            'date'         => now()->format('F j, Y, H:i:s'),
        ];

        $pdf = Pdf::loadView('permit.pdf_template', $data);
        return $pdf->download('Permit_' . $permit->id . '.pdf');
    }

    public function verify($id)
    {
        $permit = Permit::with(['tourGuide', 'teamMembers'])->findOrFail($id);
        return view('permit.verify_public', compact('permit'));
    }

    public function closingPanel(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));
        $permits = Permit::where('status', 'active')
            ->whereDate('departure_datetime', $date)
            ->with(['tourGuide'])
            ->get();

        return view('admin.permits.closing_panel', compact('permits', 'date'));
    }

    public function closePermit($id)
    {
        $permit = Permit::findOrFail($id);
        $permit->update(['status' => 'completed']);

        return redirect()->route('admin.permits.closing-panel')
            ->with('success', "Permit #{$permit->id} marked as Completed.");
    }

    public function edit($id)
    {
        $permit = Permit::with(['teamMembers', 'tourGuide'])->findOrFail($id);
        $guides = TourGuide::where('is_active', true)->get();
        return view('admin.permit.edit', compact('permit', 'guides'));
    }

    public function update(Request $request, $id)
    {
        $permit = Permit::findOrFail($id);

        $request->validate([
            'group_name'                => 'required|string|max:255',
            'leader_name'               => 'required|string|max:255',
            'leader_nid'                => 'required|string',
            'email'                     => 'required|email',
            'contact_number'            => 'required|string',
            'area_name'                 => 'required|string',
            'tour_guide_id'             => 'required|exists:tour_guides,id',
            'arrival_datetime'          => 'required',
            'departure_datetime'        => 'required',
            'status'                    => 'required|string',
            'payment_status'            => 'required',
            'vehicle_ownership'         => 'required|string',
            'vehicle_reg_no'            => 'required|string',
            'driver_name'               => 'required|string',
            'driver_contact'            => 'required|string',
            'driver_emergency_contact'  => 'nullable|string',
            'driver_blood_group'        => 'nullable|string',
            'driver_license_no'         => 'required|string',
            'driver_nid'                => 'required|string',
            'team'                      => 'required|array',
            'team.*.id'                 => 'required|exists:team_members,id',
            'team.*.name'               => 'required|string',
            'team.*.gender'             => 'required|string',
            'team.*.age_category'       => 'required|string',
        ]);

        $paymentStatusInt = ($request->payment_status === 'completed') ? 1 : 0;

        $permit->update([
            'group_name'                => $request->group_name,
            'leader_name'               => $request->leader_name,
            'leader_nid'                => $request->leader_nid,
            'email'                     => $request->email,
            'contact_number'            => $request->contact_number,
            'area_name'                 => $request->area_name,
            'tour_guide_id'             => $request->tour_guide_id,
            'arrival_datetime'          => Carbon::parse($request->arrival_datetime)->toDateTimeString(),
            'departure_datetime'        => Carbon::parse($request->departure_datetime)->toDateTimeString(),
            'status'                    => $request->status,
            'payment_status'            => $paymentStatusInt,
            'vehicle_ownership'         => $request->vehicle_ownership,
            'vehicle_reg_no'            => $request->vehicle_reg_no,
            'driver_name'               => $request->driver_name,
            'driver_contact'            => $request->driver_contact,
            'driver_emergency_contact'  => $request->driver_emergency_contact,
            'driver_blood_group'        => $request->driver_blood_group,
            'driver_license_no'         => $request->driver_license_no,
            'driver_nid'                => $request->driver_nid,
        ]);

        foreach ($request->team as $memberData) {
            TeamMember::where('id', $memberData['id'])->update([
                'name'              => $memberData['name'],
                'gender'            => $memberData['gender'],
                'age_category'      => $memberData['age_category'],
                'fathers_name'      => $memberData['fathers_name'] ?? null,
                'age'               => $memberData['age'] ?? null,
                'nid_or_passport'   => $memberData['nid_or_passport'] ?? null,
                'profession'        => $memberData['profession'] ?? null,
            ]);
        }

        return redirect()->route('admin.permit.index')->with('success', 'Permit updated successfully!');
    }
}