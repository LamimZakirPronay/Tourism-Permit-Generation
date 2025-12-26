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
     * Display a listing of the permits with advanced filters and search.
     */
    public function index(Request $request)
    {
        $query = Permit::query()->with(['tourGuide', 'areas']);

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('leader_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('id', 'LIKE', '%'.ltrim(str_replace('#', '', $searchTerm), '0').'%')
                    ->orWhere('group_name', 'LIKE', "%{$searchTerm}%");
            });
        }

        if ($request->filled('arrival_date')) {
            $query->whereDate('arrival_datetime', $request->arrival_date);
        }

        if ($request->filled('departure_date')) {
            $query->whereDate('departure_datetime', $request->departure_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

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
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png,heic,heif|max:10240',
            'arrival_datetime' => 'required|date',
            'departure_datetime' => [
                'required',
                'date',
                'after:arrival_datetime',
                function ($attribute, $value, $fail) {
                    $time = \Carbon\Carbon::parse($value)->format('H:i');
                    if ($time > '18:00') {
                        $fail('The departure time cannot be later than 6:00 PM.');
                    }
                },
            ],

            // --- MULTIPLE VEHICLES VALIDATION ---
            'vehicles' => 'required|array|min:1',
            'vehicles.*.ownership' => 'required|string',
            'vehicles.*.reg_no' => 'required|string',
            'vehicles.*.driver_name' => 'required|string',
            'vehicles.*.driver_contact' => 'required|string',
            'vehicles.*.driver_license_no' => 'nullable|string',
            'vehicles.*.driver_nid' => 'nullable|string',

            // --- TEAM MEMBERS VALIDATION ---
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

        $unitFee = \App\Models\SiteSetting::where('key', 'permit_fee')->value('value') ?? 50.00;

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

            // Remove array fields that don't belong to the main permit table
            $insertData = collect($validatedData)->except(['team', 'vehicles', 'area_ids', 'document'])->toArray();

            $insertData['is_defense'] = $request->has('is_defense') ? 1 : 0;
            $insertData['arrival_datetime'] = \Carbon\Carbon::parse($request->arrival_datetime)->toDateTimeString();
            $insertData['departure_datetime'] = \Carbon\Carbon::parse($request->departure_datetime)->toDateTimeString();
            $insertData['total_members'] = count($request->team);
            $insertData['amount'] = $totalAmount;
            $insertData['payment_status'] = 1;
            $insertData['status'] = 'to arrive';
            $insertData['bkash_trx_id'] = 'SIM_TRX_'.strtoupper(bin2hex(random_bytes(4)));
            $insertData['bkash_payment_id'] = 'BK_SIM_'.time();

            // Create the Permit
            $permit = \App\Models\Permit::create($insertData);

            // Attach Areas (Many-to-Many)
            $permit->areas()->attach($request->area_ids);

            // Save Multiple Vehicles
            // Save Multiple Vehicles
            foreach ($request->vehicles as $vehicleData) {
                $permit->vehicles()->create([
                    'vehicle_ownership' => $vehicleData['ownership'], // Changed key to match DB
                    'vehicle_reg_no' => $vehicleData['reg_no'],    // Changed key to match DB
                    'driver_name' => $vehicleData['driver_name'],
                    'driver_contact' => $vehicleData['driver_contact'],
                    'driver_license_no' => $vehicleData['driver_license_no'] ?? null,
                    'driver_nid' => $vehicleData['driver_nid'] ?? null,
                ]);
            }

            // Save Team Members
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

            return $this->geneeratePermitPDF($permit);
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

    /**
     * Update status and handle POS Tokens + Auto-download logic.
     */
    public function updateStatus(Request $request, $id)
    {
        $permit = Permit::with(['teamMembers', 'areas', 'tourGuide'])->findOrFail($id);
        $request->validate(['status' => 'required|in:to arrive,arrived,exited,cancelled']);

        try {
            $oldStatus = $permit->status;
            $permit->update(['status' => $request->status]);

            if ($request->status === 'arrived' && $oldStatus === 'to arrive') {
                $printed = $this->printIndividualMemberReceipts($permit);

                $downloadUrl = $printed
                    ? route('admin.permit.download', $permit->id)
                    : route('admin.permit.tokens.download', $permit->id);

                return back()
                    ->with($printed ? 'success' : 'warning', $printed ? 'Tokens printed. Downloading Group Permit...' : 'Printer offline. Downloading Thermal PDF...')
                    ->with('autodownload', $downloadUrl);
            }

            return back()->with('success', 'Status updated successfully.');
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
            'area_ids' => 'required|array|min:1',
            'area_ids.*' => 'exists:areas,id',
            'tour_guide_id' => 'required|exists:tour_guides,id',
            'arrival_datetime' => 'required|date',
            'departure_datetime' => 'required|date|after:arrival_datetime',
            'team' => 'required|array',
        ], [
            'area_ids.required' => 'You must select at least one restricted area.',
        ]);

        return DB::transaction(function () use ($request, $permit) {
            $permit->areas()->sync($request->area_ids);

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
                'payment_status' => (int) $request->payment_status,
                'vehicle_ownership' => $request->vehicle_ownership,
                'vehicle_reg_no' => $request->vehicle_reg_no,
                'driver_name' => $request->driver_name,
                'driver_contact' => $request->driver_contact,
                'driver_emergency_contact' => $request->driver_emergency_contact,
                'driver_blood_group' => $request->driver_blood_group,
                'driver_license_no' => $request->driver_license_no,
                'driver_nid' => $request->driver_nid,
            ]);

            if ($request->has('team')) {
                foreach ($request->team as $memberData) {
                    if (isset($memberData['id'])) {
                        TeamMember::where('id', $memberData['id'])->update([
                            'name' => $memberData['name'],
                            'fathers_name' => $memberData['fathers_name'] ?? null,
                            'age' => $memberData['age'] ?? null,
                            'gender' => $memberData['gender'] ?? 'Male',
                            'age_category' => $memberData['age_category'] ?? 'Adult',
                            'nid_or_passport' => $memberData['nid_or_passport'] ?? null,
                            'profession' => $memberData['profession'] ?? null,
                        ]);
                    }
                }
            }

            return redirect()->route('admin.permit.index')->with('success', 'Permit updated successfully with areas!');
        });
    }

    public function show($id)
    {
        $permit = Permit::with(['teamMembers', 'tourGuide', 'areas'])->findOrFail($id);

        return view('admin.permit.show', compact('permit'));
    }

    /**
     * Generate Main Group Permit (A4 PDF)
     */
    private function geneeratePermitPDF(Permit $permit)
    {
        $permit->refresh();
        $permit->load(['tourGuide', 'teamMembers', 'areas', 'vehicles']);

        $settings = \App\Models\SiteSetting::pluck('value', 'key');
        $verifyUrl = route('permit.verify', $permit->id);

        // CHANGED: Use format('svg') instead of 'png' to avoid the Imagick error
        // SVG format does NOT require the imagick extension
        $qrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
            ->size(200)
            ->errorCorrection('H')
            ->margin(1)
            ->generate($verifyUrl));

        $logoPath = isset($settings['site_logo']) ? public_path($settings['site_logo']) : null;

        $data = [
            'permit' => $permit,
            'settings' => $settings,
            'logoPath' => $logoPath,
            'instructions' => $settings['permit_instructions'] ?? 'Default instructions...',
            'contacts' => $settings['emergency_contacts'] ?? 'Default contacts...',
            'qrCode' => $qrCode, // This is now a base64 encoded SVG
            'title' => 'Restricted Area Entry Permit',
            'date' => now()->format('F j, Y, H:i:s'),
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('permit.pdf_template', $data);

        return $pdf->setPaper('a4', 'portrait')->download('Permit_'.$permit->id.'.pdf');
    }

    /**
     * NEW: Generate 80MM Thermal PDF with Dynamic Content Height
     */
    public function exportIndividualTokensPdf($id)
    {
        $permit = Permit::with(['teamMembers', 'areas'])->findOrFail($id);
        $visitSites = $permit->areas->pluck('name')->implode(', ');
        $verifyUrl = route('permit.verify', $permit->id);

        $qrCode = base64_encode(QrCode::format('svg')
            ->size(150)->errorCorrection('H')->margin(0)->generate($verifyUrl));

        $data = [
            'permit' => $permit,
            'visitSites' => $visitSites,
            'qrCode' => $qrCode,
            'date' => now()->format('d-M-Y H:i'),
        ];

        /**
         * INDUSTRY STANDARD: Calculate Height based on content
         * 80mm width = 226.77pt.
         * Average 110mm height per member = 311.81pt
         */
        $heightPerToken = 311.81;
        $totalHeight = count($permit->teamMembers) * $heightPerToken;

        return Pdf::loadView('permit.tokens_thermal_template', $data)
            ->setPaper([0, 0, 226.77, $totalHeight], 'portrait')
            ->download('Thermal_Tokens_'.$permit->id.'.pdf');
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
     * POS Thermal Printing using Daily Serial.
     */
    private function printIndividualMemberReceipts(Permit $permit)
    {
        if (! class_exists('\Mike42\Escpos\PrintConnectors\NetworkPrintConnector')) {
            \Log::error('Escpos library not found.');

            return false;
        }

        try {
            $printerIp = '192.168.1.100';
            $connector = new \Mike42\Escpos\PrintConnectors\NetworkPrintConnector($printerIp, 9100);
            $profile = \Mike42\Escpos\CapabilityProfile::load('default');
            $printer = new \Mike42\Escpos\Printer($connector, $profile);

            $visitSites = $permit->areas->pluck('name')->implode(', ');
            $verifyUrl = route('permit.verify', $permit->id);

            // Get Daily Serial from Model Attribute
            $dailySerial = $permit->daily_serial;

            foreach ($permit->teamMembers as $index => $member) {
                $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_CENTER);
                $printer->selectPrintMode(\Mike42\Escpos\Printer::MODE_DOUBLE_WIDTH);
                $printer->text("ENTRY TOKEN\n");
                $printer->selectPrintMode();
                $printer->text("--------------------------------\n");

                // Combined Daily Serial + Member Index (e.g., 005-01)
                $tokenNo = $dailySerial.'-'.str_pad($index + 1, 2, '0', STR_PAD_LEFT);

                $printer->feed();
                $printer->selectPrintMode(\Mike42\Escpos\Printer::MODE_DOUBLE_WIDTH | \Mike42\Escpos\Printer::MODE_DOUBLE_HEIGHT);
                $printer->text('#'.$tokenNo."\n");
                $printer->selectPrintMode();
                $printer->feed();

                $printer->qrCode($verifyUrl, \Mike42\Escpos\Printer::QR_ECLEVEL_L, 8);
                $printer->feed();

                $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_LEFT);
                $printer->text('Group : '.$permit->group_name."\n");
                $printer->text('Name  : '.$member->name."\n");
                $printer->text('Visit : '.$visitSites."\n");
                $printer->text('Date  : '.now()->format('d-M-Y H:i')."\n");

                $printer->feed(2);
                $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_CENTER);
                $printer->text("NON-TRANSFERABLE PERMIT\n");
                $printer->text("********************************\n");
                $printer->feed(3);
                $printer->cut();
            }

            $printer->close();

            return true;
        } catch (\Exception $e) {
            \Log::error('POS Printer Error: '.$e->getMessage());

            return false;
        }
    }

    public function downloadPDF($id)
    {
        $permit = Permit::findOrFail($id);

        return $this->exportGroupPermitPDF($permit);
    }

    public function closingPanel(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));
        $permits = Permit::where('status', 'arrived')
            ->whereDate('departure_datetime', $date)
            ->with(['tourGuide', 'areas'])
            ->get();

        return view('admin.permits.closing_panel', compact('permits', 'date'));
    }

    public function markAsExited($id)
    {
        $permit = Permit::findOrFail($id);
        $permit->update(['status' => 'exited']);

        return back()->with('success', 'Group '.$permit->group_name.' has been marked as exited.');
    }
}
