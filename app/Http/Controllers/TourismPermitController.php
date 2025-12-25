<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Permit;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use App\Models\TourGuide;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TourismPermitController extends Controller
{
    /**
     * Display a listing of the permits.
     */
    /**
     * Display a listing of the permits with advanced filters and search.
     */
    public function index(Request $request)
    {
        // 1. Initialize query with relationships
        $query = Permit::query()->with(['tourGuide', 'areas']);

        // 2. SEARCH: Search by Leader Name OR Permit ID
        if ($request->filled('search')) {
            $searchTerm = $request->search;

            $query->where(function ($q) use ($searchTerm) {
                // Search Leader Name
                $q->where('leader_name', 'LIKE', "%{$searchTerm}%")
                  // Search Permit ID (removes leading zeros/hashes if user types #00005 or 00005)
                    ->orWhere('id', 'LIKE', '%'.ltrim(str_replace('#', '', $searchTerm), '0').'%')
                  // Search Group Name (Added for better UX)
                    ->orWhere('group_name', 'LIKE', "%{$searchTerm}%");
            });
        }

        // 3. FILTER: Arrival Date
        if ($request->filled('arrival_date')) {
            $query->whereDate('arrival_datetime', $request->arrival_date);
        }

        // 4. FILTER: Departure Date
        if ($request->filled('departure_date')) {
            $query->whereDate('departure_datetime', $request->departure_date);
        }

        // 5. FILTER: Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 6. Execute with Pagination and keep filter parameters in links
        $permits = $query->latest('created_at')->paginate(10);

        return view('admin.permit.index', compact('permits'));
    }

    /**
     * Show the permit creation form.
     */
    public function create()
    {
        $guides = TourGuide::where('is_active', true)->get();
        $areas = Area::where('is_active', true)->orderBy('name', 'asc')->get();

        $settings = SiteSetting::pluck('value', 'key');
        $adultFee = $settings['permit_fee'] ?? 50.00;

        $logoFileName = $settings['site_logo'] ?? 'default-logo.png';
        $logoUrl = asset('storage/'.$logoFileName);

        return view('permit.create', compact('areas', 'guides', 'adultFee', 'settings', 'logoUrl'));
    }

    /**
     * Store a newly created permit.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'group_name' => 'required|string|max:255',
            'leader_name' => 'required|string|max:255',
            'leader_nid' => 'required|string',
            'is_defense' => 'nullable|boolean',
            'email' => 'required|email',
            'contact_number' => 'required|string',
            'area_ids' => 'required|array|min:1',
            'area_ids.*' => 'exists:areas,id',
            'tour_guide_id' => 'required|exists:tour_guides,id',
            'document' => 'required|mimes:pdf|max:5120',
            'arrival_datetime' => 'required|date',
            'departure_datetime' => [
                'required',
                'date',
                'after:arrival_datetime',
                function ($attribute, $value, $fail) {
                    $time = Carbon::parse($value)->format('H:i');
                    if ($time > '18:00') {
                        $fail('The departure time cannot be later than 6:00 PM.');
                    }
                },
            ],
            'vehicle_ownership' => 'required|string',
            'vehicle_reg_no' => 'required|string',
            'driver_name' => 'required|string',
            'driver_contact' => 'required|string',
            'driver_emergency_contact' => 'nullable|string',
            'driver_blood_group' => 'nullable|string',
            'driver_license_no' => 'nullable|string',
            'driver_nid' => 'nullable|string',
            'team' => 'required|array|min:1',
            'team.*.name' => 'required|string',
            'team.*.fathers_name' => 'required|string',
            'team.*.age' => 'required|integer|min:0',
            'team.*.gender' => 'required|string|in:Male,Female,Other',
            'team.*.age_category' => 'required|string|in:Adult,Children,Infant',
            'team.*.address' => 'required|string',
            'team.*.profession' => 'nullable|string',
            'team.*.contact_number' => 'required|string',
            'team.*.emergency_contact' => 'required|string',
            'team.*.blood_group' => 'required|string',
            'team.*.id' => 'required|string',
        ]);

        $unitFee = SiteSetting::where('key', 'permit_fee')->value('value') ?? 50.00;

        if ($request->has('is_defense') && $request->is_defense == 1) {
            $totalAmount = $unitFee;
        } else {
            $adultCount = collect($request->team)->where('age_category', 'Adult')->count();
            $totalAmount = $unitFee * $adultCount;
        }

        return DB::transaction(function () use ($request, $validatedData, $totalAmount) {

            if ($request->hasFile('document')) {
                $path = $request->file('document')->store('permits', 'public');
                $validatedData['document_path'] = $path;
            }

            $insertData = collect($validatedData)->except(['team', 'area_ids'])->toArray();
            $insertData['is_defense'] = $request->has('is_defense') ? 1 : 0;
            $insertData['arrival_datetime'] = Carbon::parse($request->arrival_datetime)->toDateTimeString();
            $insertData['departure_datetime'] = Carbon::parse($request->departure_datetime)->toDateTimeString();
            $insertData['total_members'] = count($request->team);
            $insertData['amount'] = $totalAmount;
            $insertData['payment_status'] = 1;
            $insertData['status'] = 'to arrive'; // Default initial status
            $insertData['bkash_trx_id'] = 'SIM_TRX_'.strtoupper(bin2hex(random_bytes(4)));
            $insertData['bkash_payment_id'] = 'BK_SIM_'.time();

            $permit = Permit::create($insertData);
            $permit->areas()->attach($request->area_ids);

            foreach ($request->team as $memberData) {
                $permit->teamMembers()->create([
                    'name' => $memberData['name'],
                    'fathers_name' => $memberData['fathers_name'],
                    'age' => $memberData['age'],
                    'gender' => $memberData['gender'],
                    'age_category' => $memberData['age_category'],
                    'address' => $memberData['address'],
                    'profession' => $memberData['profession'],
                    'contact_number' => $memberData['contact_number'],
                    'emergency_contact' => $memberData['emergency_contact'],
                    'blood_group' => $memberData['blood_group'],
                    'nid_or_passport' => $memberData['id'],
                ]);
            }

            return $this->generatePermitPDF($permit);
        });
    }

    /**
     * Show the edit form.
     */
    public function edit($id)
    {
        $permit = Permit::with(['teamMembers', 'tourGuide', 'areas'])->findOrFail($id);
        $guides = TourGuide::where('is_active', true)->get();
        $areas = Area::where('is_active', true)->orderBy('name', 'asc')->get();

        return view('admin.permit.edit', compact('permit', 'guides', 'areas'));
    }

    public function updateStatus(Request $request, $id)
    {
        $permit = Permit::findOrFail($id);

        $request->validate([
            'status' => 'required|in:to arrive,arrived,exited,cancelled',
        ]);

        try {
            $permit->update(['status' => $request->status]);

            $msg = 'Permit status updated to '.strtoupper($request->status);

            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', 'Error: '.$e->getMessage());
        }
    }

    /**
     * Update an existing permit.
     */
    public function update(Request $request, $id)
    {
        $permit = Permit::findOrFail($id);

        $request->validate([
            'group_name' => 'required|string|max:255',
            'leader_name' => 'required|string|max:255',
            'leader_nid' => 'required|string',
            'email' => 'required|email',
            'contact_number' => 'required|string',
            'area_id' => 'required|exists:areas,id',
            'tour_guide_id' => 'required|exists:tour_guides,id',
            'arrival_datetime' => 'required|date',
            'departure_datetime' => 'required|date|after:arrival_datetime',
            'status' => 'required|in:to arrive,arrived,exited,cancelled',
            'payment_status' => 'required',
            'vehicle_ownership' => 'required|string',
            'vehicle_reg_no' => 'required|string',
            'driver_name' => 'required|string',
            'driver_contact' => 'required|string',
            'driver_license_no' => 'required|string',
            'driver_nid' => 'required|string',
            'team' => 'required|array',
            'team.*.id' => 'required|exists:team_members,id',
            'team.*.name' => 'required|string',
        ]);

        return DB::transaction(function () use ($request, $permit) {

            // Sync Areas (Many-to-Many)
            $permit->areas()->sync([$request->area_id]);

            // Update Master
            $permit->update([
                'group_name' => $request->group_name,
                'leader_name' => $request->leader_name,
                'leader_nid' => $request->leader_nid,
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'tour_guide_id' => $request->tour_guide_id,
                'arrival_datetime' => Carbon::parse($request->arrival_datetime)->toDateTimeString(),
                'departure_datetime' => Carbon::parse($request->departure_datetime)->toDateTimeString(),
                'status' => $request->status,
                'payment_status' => ($request->payment_status === 'completed' || $request->payment_status == 1) ? 1 : 0,
                'vehicle_ownership' => $request->vehicle_ownership,
                'vehicle_reg_no' => $request->vehicle_reg_no,
                'driver_name' => $request->driver_name,
                'driver_contact' => $request->driver_contact,
                'driver_emergency_contact' => $request->driver_emergency_contact,
                'driver_blood_group' => $request->driver_blood_group,
                'driver_license_no' => $request->driver_license_no,
                'driver_nid' => $request->driver_nid,
            ]);

            // Update Team
            foreach ($request->team as $memberData) {
                TeamMember::where('id', $memberData['id'])->update([
                    'name' => $memberData['name'],
                    'gender' => $memberData['gender'] ?? 'Male',
                    'age_category' => $memberData['age_category'] ?? 'Adult',
                    'fathers_name' => $memberData['fathers_name'] ?? null,
                    'age' => $memberData['age'] ?? null,
                    'nid_or_passport' => $memberData['nid_or_passport'] ?? null,
                    'profession' => $memberData['profession'] ?? null,
                ]);
            }

            return redirect()->route('admin.permit.index')->with('success', 'Permit updated successfully!');
        });
    }

    /**
     * Display a single permit.
     */
    public function show($id)
    {
        $permit = Permit::with(['teamMembers', 'tourGuide', 'areas'])->findOrFail($id);

        return view('admin.permit.show', compact('permit'));
    }

    /**
     * Generate PDF for a permit.
     */
    private function generatePermitPDF(Permit $permit)
    {
        $permit->refresh();
        $permit->load(['tourGuide', 'teamMembers', 'areas']);

        $settings = SiteSetting::pluck('value', 'key');
        $verifyUrl = route('permit.verify', $permit->id);

        $qrCode = base64_encode(QrCode::format('svg')
            ->size(150)->errorCorrection('H')->margin(1)->generate($verifyUrl));

        $data = [
            'permit' => $permit,
            'instructions' => $settings['permit_instructions'] ?? 'Default instructions...',
            'contacts' => $settings['emergency_contacts'] ?? 'Default contacts...',
            'qrCode' => $qrCode,
            'title' => 'Restricted Area Entry Permit',
            'date' => now()->format('F j, Y, H:i:s'),
        ];

        $pdf = Pdf::loadView('permit.pdf_template', $data);

        return $pdf->download('Permit_'.$permit->id.'.pdf');
    }

    /**
     * Public verification page via QR.
     */
    public function verify($id)
    {
        $permit = Permit::with(['tourGuide', 'teamMembers', 'areas'])->findOrFail($id);

        return view('permit.verify_public', compact('permit'));
    }

    /**
     * Closing panel for admins.
     */
    public function closingPanel(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));
        $permits = Permit::where('status', 'arrived')
            ->whereDate('departure_datetime', $date)
            ->with(['tourGuide', 'areas'])
            ->get();

        return view('admin.permits.closing_panel', compact('permits', 'date'));
    }

    /**
     * Quick mark as exited.
     */
    public function markAsExited($id)
    {
        $permit = Permit::findOrFail($id);
        $permit->update(['status' => 'exited']);

        return back()->with('success', 'Group '.$permit->group_name.' has been marked as exited.');
    }
}
