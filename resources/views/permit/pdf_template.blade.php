<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Permit - {{ $permit->group_name }}</title>
<style>
        @page { margin: 100px 25px; }
        header { position: fixed; top: -60px; left: 0px; right: 0px; height: 50px; }
        footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; }
        
        body { 
            font-family: 'DejaVu Sans', sans-serif; 
            font-size: 10px; 
            color: #333; 
            line-height: 1.4; 
        }
        
        .header-content { border-bottom: 2px solid #198754; padding-bottom: 10px; }
        .header-content h1 { color: #198754; margin: 0; text-transform: uppercase; font-size: 16px; }
        
        .section-title { background: #e9ecef; padding: 5px 10px; font-weight: bold; border-left: 4px solid #198754; margin-top: 15px; text-transform: uppercase; font-size: 11px; }
        
        .info-table { width: 100%; margin-top: 10px; border: 1px solid #eee; border-collapse: collapse; }
        .info-table td { padding: 8px; vertical-align: top; border-bottom: 1px solid #eee; border-right: 1px solid #eee; }
        .label { font-weight: bold; color: #555; display: block; font-size: 8px; text-transform: uppercase; }

        .member-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .member-table th { background-color: #198754; color: white; padding: 8px; text-align: left; font-size: 9px; text-transform: uppercase; }
        .member-table td { border: 1px solid #ddd; padding: 6px; text-align: left; vertical-align: top; }
        
        .payment-summary { width: 100%; margin-top: 20px; border: 2px solid #198754; border-collapse: collapse; }
        .payment-summary td { padding: 10px; }
        .total-box { background-color: #198754; color: white; text-align: right; }
        
        .pagenum:before { content: counter(page); }
        .status-badge { color: #198754; font-weight: bold; border: 1px solid #198754; padding: 2px 5px; border-radius: 3px; }
        
        .defense-badge { display: inline-block; background-color: #064e3b; color: white; padding: 2px 8px; border-radius: 4px; font-size: 8px; margin-left: 10px; text-transform: uppercase; vertical-align: middle; }

        .instructions-box { margin-top: 20px; border: 1px solid #ccc; padding: 10px; font-size: 9px; page-break-inside: avoid; }
        .emergency-box { margin-top: 10px; background-color: #fff3f3; border: 1px solid #ebcccc; padding: 10px; color: #a94442; }
        
        /* New style for vehicle separation */
        .vehicle-container { margin-bottom: 10px; border: 1px solid #ddd; padding: 5px; }
    </style>
</head>

@php
    $settings = \App\Models\SiteSetting::pluck('value', 'key');
    
    $feePerAdult = (float) ($settings['permit_fee'] ?? 100); 
    $adultCount = $permit->teamMembers->where('age_category', 'Adult')->count();
    $childCount = $permit->teamMembers->where('age_category', 'Children')->count();
    $infantCount = $permit->teamMembers->where('age_category', 'Infant')->count();
    
    if($permit->is_defense) {
        $totalAmount = $feePerAdult;
    } else {
        $totalAmount = $adultCount * $feePerAdult;
    }
@endphp

<body>
    <header>
        <div class="header-content">
            <table width="100%" style="border:none;">
                <tr>
                    <td width="15%" style="border:none; text-align: left; vertical-align: middle;">
                        @if(isset($settings['site_logo']))
                            <img src="{{ public_path($settings['site_logo']) }}" style="height: 55px; width: auto;">
                        @endif
                    </td>
                    <td width="85%" style="border:none; text-align: right; vertical-align: middle;">
                        <h1>{{ $settings['site_name'] ?? 'Restricted Area Entry Permit' }}</h1>
                        <p style="margin: 3px 0; font-weight: bold; color: #666;">Official Authorization Document</p>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <footer>
        <table width="100%" style="border-top: 1px solid #ddd; padding-top: 5px;">
            <tr>
               <td width="33%">Ref: {{ $permit->id }}</td>
                <td width="33%" align="center">Page <span class="pagenum"></span></td>
                <td width="33%" align="right">Printed: {{ date('d-m-Y H:i') }}</td>
            </tr>
        </table>
    </footer>

    <main>
        <div class="section-title">General Information</div>
        <table class="info-table">
            <tr>
                <td width="50%"><span class="label">Group Name</span> {{ $permit->group_name }}</td>
                <td width="50%">
                    <span class="label">Restricted Areas</span> 
                    <strong style="color: #198754;">{{ $permit->areas->pluck('name')->implode(', ') }}</strong>
                </td>
            </tr>
            <tr>
                <td><span class="label">Arrival Date & Time</span> {{ \Carbon\Carbon::parse($permit->arrival_datetime)->format('d M, Y - h:i A') }}</td>
                <td><span class="label">Departure Date & Time</span> {{ \Carbon\Carbon::parse($permit->departure_datetime)->format('d M, Y - h:i A') }}</td>
            </tr>
            <tr>
                <td><span class="label">Payment Status</span> <span class="status-badge">PAID / AUTHORIZED</span></td>
                <td><span class="label">Assigned Guide</span> {{ $permit->tourGuide->name ?? 'None Assigned' }}</td>
            </tr>
        </table>

        <div class="section-title">
            Lead Applicant Details 
            @if($permit->is_defense) <span class="defense-badge">Defense Personnel</span> @endif
        </div>
        <table class="info-table">
            <tr>
                <td width="33%"><span class="label">Full Name</span> {{ $permit->leader_name }}</td>
                <td width="33%"><span class="label">NID/Passport</span> {{ $permit->leader_nid }}</td>
                <td width="33%"><span class="label">Mobile</span> {{ $permit->contact_number }}</td>
            </tr>
        </table>

        <div class="section-title">Authorized Vehicles & Drivers (Total: {{ $permit->vehicles->count() }})</div>
        @foreach($permit->vehicles as $index => $vehicle)
        <div class="vehicle-container">
            <table class="info-table" style="margin-top: 0; border: none;">
                <tr>
                    <td colspan="3" style="background: #f8f9fa; font-weight: bold;">Vehicle #{{ $index + 1 }}</td>
                </tr>
                <tr>
                    <td width="33%"><span class="label">Driver Name</span> {{ $vehicle->driver_name }}</td>
                    <td width="33%"><span class="label">License No.</span> {{ $vehicle->driver_license_no }}</td>
                    <td width="33%"><span class="label">Driver NID</span> {{ $vehicle->driver_nid }}</td>
                </tr>
                <tr>
                    <td><span class="label">Driver Contact</span> {{ $vehicle->driver_contact }}</td>
                    <td><span class="label">Vehicle Ownership</span> {{ $vehicle->vehicle_ownership }}</td>
                    <td><span class="label">Registration No.</span> {{ $vehicle->vehicle_reg_no }}</td>
                </tr>
            </table>
        </div>
        @endforeach

        <div class="section-title">Verified Team Members (Total: {{ $permit->total_members }})</div>
        <table class="member-table">
            <thead>
                <tr>
                    <th width="25%">Name & Category</th>
                    <th width="15%">Age & Blood</th>
                    <th width="20%">Profession & ID</th>
                    <th width="20%">Contact Info</th>
                    <th width="20%">Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permit->teamMembers as $member)
                <tr>
                    <td><strong>{{ $member->name }}</strong><br><small style="color: #198754;">{{ $member->age_category }}</small></td>
                    <td>{{ $member->age }} Yrs | {{ $member->blood_group }}</td>
                    <td>{{ $member->profession }}<br>{{ $member->nid_or_passport }}</td>
                    <td>{{ $member->contact_number }}</td>
                    <td>{{ $member->address }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="section-title">Payment Breakdown</div>
        <table class="payment-summary">
            <tr>
                <td width="70%">
                    <strong style="font-size: 11px;">Fee Calculation:</strong><br>
                    @if($permit->is_defense)
                        Defense Personnel Flat Fee: 1 x ৳{{ number_format($feePerAdult, 2) }}
                    @else
                        Adults: {{ $adultCount }} x ৳{{ number_format($feePerAdult, 2) }} | Children: {{ $childCount }} (Free)
                    @endif
                </td>
                <td width="30%" class="total-box">
                    <span style="font-size: 10px;">Total Paid</span><br>
                    <span style="font-size: 18px; font-weight: bold;">৳{{ number_format($totalAmount, 2) }}</span>
                </td>
            </tr>
        </table>

        <div class="qr-section">
            <table width="100%" style="border:none;">
                <tr>
                    <td width="70%" style="border:none;">
                        <h3 style="color: #198754; margin: 0;">OFFICIAL VERIFICATION</h3>
                        <p style="font-size: 9px;">Scan the QR code to verify this permit's authenticity.</p>
                        <div class="instructions-box">
                            <strong>Instructions:</strong><br>
                            {{ $settings['permit_instructions'] ?? 'Standard restricted area rules apply.' }}
                        </div>
                    </td>
                    <td width="30%" style="border:none; text-align: right;">
                        <img src="data:image/png;base64, {!! $qrCode !!}" style="height: 120px; width: 120px; border: 1px solid #eee; padding: 5px;">
                    </td>
                </tr>
            </table>
        </div>

        <div class="emergency-box">
            <h3 style="color: #d9534f; margin-top: 0;">In Case of Emergency:</h3>
            <div>{{ $settings['emergency_contacts'] ?? 'Please contact the local authorities.' }}</div>
        </div>
    </main>
</body>
</html>