@php
    $settings = \App\Models\SiteSetting::pluck('value', 'key');
    $adultFee = \App\Models\SiteSetting::where('key', 'permit_fee')->value('value') ?? 50.00;
    $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
    $oldTeam = old('team', [[]]); 
    $oldVehicles = old('vehicles', [[]]);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourism Permit Application | পর্যটন অনুমতি আবেদন</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    
    <style>
        :root { --forest-green: #065f46; --soft-green: #10b981; }
        body { 
            background: linear-gradient(rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0.4)), 
                        url('https://images.unsplash.com/photo-1660703080906-f4ac0cb7ea43?q=80&w=1974&auto=format&fit=crop');
            background-size: cover; background-attachment: fixed; color: #1e293b;
        }
        .form-card { 
            background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(15px); 
            border-radius: 1rem; box-shadow: 0 4px 6px rgba(0,0,0,0.05); 
            margin-bottom: 2rem; padding: 2rem !important; border: none;
        }
        .step-badge {
            background-color: #143603ff; color: white; width: 32px; height: 32px;
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 50%; margin-right: 12px; font-weight: bold;
        }
        .section-title { font-size: 1.25rem; font-weight: 700; color: var(--forest-green); margin-bottom: 1.5rem; display: flex; align-items: center; }
        .member-card, .vehicle-card { 
            border: 1px solid #e2e8f0; border-left: 6px solid var(--soft-green); 
            border-radius: 12px; background: #ffffff !important; padding: 1.5rem !important; margin-bottom: 1.5rem; position: relative;
        }
        .remove-row, .remove-vehicle { top: -10px; right: -10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); z-index: 10; }
        .form-label { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.4rem; font-weight: 700; }
        .text-required { color: #dc3545; margin-left: 2px; }
        .help-text { font-size: 0.75rem; color: #6c757d; margin-top: 0.25rem; display: block; }
        .main-title-container { background: rgba(255, 255, 255, 0.95); padding: 20px 60px; border-radius: 100px; display: inline-flex; align-items: center; gap: 30px; min-width: 60%; backdrop-filter: blur(10px); }
        
        .form-control, .form-select {
            height: 38px !important;
            border: 1px solid #dee2e6 !important;
            border-radius: 0.375rem !important;
            font-size: 0.9rem;
        }
        input[type="file"].form-control { line-height: 24px; }
        .select2-container--bootstrap-5 .select2-selection--multiple {
            border: 1px solid #dee2e6 !important;
            border-radius: 0.375rem !important;
            min-height: 38px !important; 
            display: flex !important;
            align-items: center !important;
        }
        .select2-container { width: 100% !important; }

        @media (min-width: 768px) {
            .border-md-end { border-right: 2px solid #e2e8f0 !important; }
        }
    </style>
</head>
<body>

<div class="container my-5">
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-exclamation-octagon-fill me-2 fs-5"></i>
                <strong class="fs-6">Validation Errors / যাচাইকরণ ত্রুটি:</strong>
            </div>
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="text-center mb-4 mb-md-5 px-2">
        <div class="main-title-container shadow-lg border border-white border-2 d-flex flex-column flex-md-row align-items-center justify-content-center p-3 p-md-4 gap-3">
            @if(isset($settings['site_logo']))
                <div class="logo-wrapper border-md-end pe-md-4 mb-3 mb-md-0">
                    <img src="{{ $settings['site_logo'] }}" alt="Logo" class="img-fluid" style="height: 60px; width: auto; max-width: 150px; object-fit: contain;" onerror="this.src='https://placehold.co/100x100?text=Logo';">
                </div>
            @endif
            <div class="text-center text-md-start">
                <h1 class="text-success fw-bold mb-0" style="font-size: clamp(1.5rem, 5vw, 2.2rem);">
                    {{ $settings['site_name'] ?? 'Tourism Entry Permit' }}
                </h1>
                <div class="d-flex align-items-center justify-content-center justify-content-md-start mt-2">
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-bold text-uppercase" style="font-size: 0.65rem;">
                        Managed by Ruma Zone | রুমা জোন দ্বারা পরিচালিত
                    </span>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('permit.store') }}" method="POST" enctype="multipart/form-data" id="permitForm">
        @csrf

        <div class="row g-4">
            <div class="col-lg-8">
                {{-- STEP 1: TRIP DETAILS --}}
                <div class="card form-card">
                    <div class="section-title border-bottom pb-2 mb-4">
                        <span class="step-badge">1</span> Trip Details / ভ্রমণের বিবরণ
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Group Name / গ্রুপের নাম<span class="text-required">*</span></label>
                            <input type="text" class="form-control" name="group_name" value="{{ old('group_name') }}" required placeholder="Enter group alias">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Destination Areas / গন্তব্য এলাকা<span class="text-required">*</span></label>
                            <select name="area_ids[]" id="destination-select" class="form-control" multiple="multiple" required>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}" {{ (is_array(old('area_ids')) && in_array($area->id, old('area_ids'))) ? 'selected' : '' }}>
                                        {{ $area->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Click to add multiple areas / গন্তব্য যোগ করতে ক্লিক করুন</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Arrival / পৌঁছানোর সময়<span class="text-required">*</span></label>
                            <input type="datetime-local" class="form-control" name="arrival_datetime" value="{{ old('arrival_datetime') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Departure / প্রস্থানের সময়<span class="text-required">*</span></label>
                            <input type="datetime-local" class="form-control" name="departure_datetime" value="{{ old('departure_datetime') }}" required>
                            <div class="text-danger mt-1" style="font-size: 0.75rem; font-weight: 500;">
                                <i class="bi bi-exclamation-triangle-fill"></i> Note: You cannot depart after 6:00 PM. / বিশেষ দ্রষ্টব্য: সন্ধ্যা ৬:০০ টার পর প্রস্থান করা যাবে না।
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 2: LEAD APPLICANT --}}
                <div class="card form-card">
                    <div class="section-title border-bottom pb-2 mb-4"><span class="step-badge">2</span> Lead Applicant / প্রধান আবেদনকারী</div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Leader Name / প্রধান আবেদনকারী পূর্ণ নাম<span class="text-required">*</span></label>
                            <input type="text" class="form-control" name="leader_name" value="{{ old('leader_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Leader NID / এনআইডি বা পাসপোর্ট<span class="text-required">*</span></label>
                            <input type="text" class="form-control" name="leader_nid" value="{{ old('leader_nid') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email / ইমেল ঠিকানা<span class="text-required">*</span></label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact / মোবাইল নম্বর<span class="text-required">*</span></label>
                            <input type="text" class="form-control" name="contact_number" value="{{ old('contact_number') }}" required>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch p-3 border rounded-3 bg-light d-flex align-items-center">
                                <input class="form-check-input ms-0 me-3" type="checkbox" name="is_defense" id="is_defense" value="1" {{ old('is_defense') ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold text-primary" for="is_defense">
                                    <i class="bi bi-shield-check me-1"></i> Is the Leader a Defense Personnel? / প্রধান আবেদনকারী কি প্রতিরক্ষা বাহিনীর সদস্য?
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Team Lead's NID/Passport (PDF/Image) / টিম লিডারের এনআইডি বা পাসপোর্ট<span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="document" accept=".pdf, .jpg, .jpeg, .png, .heic, .heif" required>
                            <div class="d-flex flex-column mt-1">
                                <span class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-info-circle"></i> Please upload the Team Lead's NID card or Passport copy.</span>
                                <span class="text-primary mt-1" style="font-size: 0.7rem; font-weight: 500;">* If you have multiple pages, please combine them into one PDF.</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 4: TEAM MEMBERS --}}
                <div class="card form-card">
                    <div class="section-title justify-content-between border-bottom pb-2 mb-4">
                        <div><span class="step-badge">4</span> Team Members (Including Team Lead) / দলের সদস্যগণ</div>
                        <button type="button" id="add-member-btn" class="btn btn-success btn-sm rounded-pill px-3"><i class="bi bi-person-plus"></i> Add Member</button>
                    </div>
                    <div id="team-members-wrapper">
                        @foreach($oldTeam as $index => $member)
                        <div class="member-card member-row">
                            <button type="button" class="btn btn-danger btn-sm rounded-circle remove-row position-absolute" style="{{ $index == 0 ? 'display:none;' : '' }}"><i class="bi bi-x"></i></button>
                            <div class="row g-3">
                                <div class="col-md-5"><label class="form-label">Full Name / পূর্ণ নাম<span class="text-required">*</span></label><input type="text" name="team[{{ $index }}][name]" value="{{ $member['name'] ?? '' }}" class="form-control" required></div>
                                <div class="col-md-5"><label class="form-label">Father's Name / পিতার নাম<span class="text-required">*</span></label><input type="text" name="team[{{ $index }}][fathers_name]" value="{{ $member['fathers_name'] ?? '' }}" class="form-control" required></div>
                                <div class="col-md-2"><label class="form-label">Age / বয়স<span class="text-required">*</span></label><input type="number" name="team[{{ $index }}][age]" value="{{ $member['age'] ?? '' }}" class="form-control" required></div>
                                <div class="col-md-3">
                                    <label class="form-label">Gender / লিঙ্গ<span class="text-required">*</span></label>
                                    <select name="team[{{ $index }}][gender]" class="form-select" required>
                                        <option value="Male" {{ ($member['gender'] ?? '') == 'Male' ? 'selected' : '' }}>Male / পুরুষ</option>
                                        <option value="Female" {{ ($member['gender'] ?? '') == 'Female' ? 'selected' : '' }}>Female / মহিলা</option>
                                    </select>
                                </div>
                           <div class="col-md-4">
    <div class="d-flex align-items-center justify-content-between mb-1">
        <label class="form-label mb-0">Category / শ্রেণী<span class="text-required">*</span></label>
        <button type="button" 
                class="btn btn-link p-0 text-decoration-none" 
                data-bs-toggle="tooltip" 
                data-bs-placement="top" 
                data-bs-html="true" 
title="Adult (প্রাপ্তবয়স্ক): Above 8 years. Child (শিশু): 3-8 years. Infant (নবজাতক): Under 3 years.">            <i class="bi bi-info-circle text-primary" style="font-size: 0.9rem;"></i>
        </button>
    </div>
    <select name="team[{{ $index }}][age_category]" class="form-select age-category-select" required>
        <option value="Adult" {{ ($member['age_category'] ?? '') == 'Adult' ? 'selected' : '' }}>Adult / প্রাপ্তবয়স্ক</option>
        <option value="Children" {{ ($member['age_category'] ?? '') == 'Children' ? 'selected' : '' }}>Children / শিশু</option>
        <option value="Infant" {{ ($member['age_category'] ?? '') == 'Infant' ? 'selected' : '' }}>Infant / নবজাতক</option>
    </select>
</div>
<div class="col-md-5">
    <div class="d-flex align-items-center justify-content-between mb-1">
        <label class="form-label mb-0">NID / Passport / এনআইডি<span class="text-required">*</span></label>
        <button type="button" 
                class="btn btn-link p-0 text-decoration-none" 
                data-bs-toggle="tooltip" 
                data-bs-placement="top" 
                title="For Minors, use parent's NID / অপ্রাপ্তবয়স্কদের ক্ষেত্রে অভিভাবকের এনআইডি ব্যবহার করুন">
            <i class="bi bi-info-circle text-primary" style="font-size: 0.85rem;"></i>
        </button>
    </div>
    <input type="text" 
           name="team[{{ $index }}][id]" 
           value="{{ $member['id'] ?? '' }}" 
           class="form-control" 
           placeholder="Enter NID or Passport / নম্বরটি লিখুন" 
           required>
</div>                                <div class="col-md-3">
                                    <label class="form-label">Blood / রক্ত<span class="text-required">*</span></label>
                                    <select name="team[{{ $index }}][blood_group]" class="form-select" required>
                                        <option value="">Select</option>
                                        @foreach($bloodGroups as $bg)<option value="{{ $bg }}" {{ ($member['blood_group'] ?? '') == $bg ? 'selected' : '' }}>{{ $bg }}</option>@endforeach
                                    </select>
                                </div>
                                <div class="col-md-4"><label class="form-label">Contact / মোবাইল<span class="text-required">*</span></label><input type="text" name="team[{{ $index }}][contact_number]" value="{{ $member['contact_number'] ?? '' }}" class="form-control" required></div>
                                <div class="col-md-5"><label class="form-label">Emergency / জরুরি যোগাযোগ<span class="text-required">*</span></label><input type="text" name="team[{{ $index }}][emergency_contact]" value="{{ $member['emergency_contact'] ?? '' }}" class="form-control" required></div>
                                <div class="col-md-4"><label class="form-label">Profession / পেশা</label><input type="text" name="team[{{ $index }}][profession]" value="{{ $member['profession'] ?? '' }}" class="form-control"></div>
                                <div class="col-8"><label class="form-label">Address / স্থায়ী ঠিকানা<span class="text-required">*</span></label><input type="text" name="team[{{ $index }}][address]" value="{{ $member['address'] ?? '' }}" class="form-control" required></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- STEP 3: DRIVER & VEHICLES --}}
                <div class="card form-card">
                    <div class="section-title justify-content-between border-bottom pb-2 mb-4">
                        <div><span class="step-badge">3</span> Driver & Vehicles / চালক ও যানবাহন</div>
                        <button type="button" id="add-vehicle-btn" class="btn btn-outline-success btn-sm rounded-pill px-3"><i class="bi bi-plus-circle"></i> Add Vehicle</button>
                    </div>
                    <div id="vehicles-wrapper">
                        @foreach($oldVehicles as $vIndex => $vehicle)
                        <div class="vehicle-card vehicle-row">
                            <button type="button" class="btn btn-danger btn-sm rounded-circle remove-vehicle position-absolute" style="{{ $vIndex == 0 ? 'display:none;' : '' }}"><i class="bi bi-x"></i></button>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Vehicle / যানবাহন<span class="text-required">*</span></label>
                                    <select name="vehicles[{{ $vIndex }}][ownership]" class="form-select" required>
        <option value="" disabled selected>Select / নির্বাচন করুন</option>
        <option value="Local Car" {{ ($vehicle['ownership'] ?? '') == 'Local Car' ? 'selected' : '' }}>
            Local (Chander Gari) / স্থানীয় (চান্দের গাড়ি)
        </option>
        <option value="Personal Car" {{ ($vehicle['ownership'] ?? '') == 'Personal Car' ? 'selected' : '' }}>
            Personal Car / ব্যক্তিগত গাড়ি
        </option>
        <option value="Motorbike" {{ ($vehicle['ownership'] ?? '') == 'Motorbike' ? 'selected' : '' }}>
            Motorbike / মোটরসাইকেল
        </option>
    </select>
                                </div>
                                <div class="col-md-4"><label class="form-label">Reg No. / রেজি নম্বর<span class="text-required">*</span></label><input type="text" name="vehicles[{{ $vIndex }}][reg_no]" class="form-control" value="{{ $vehicle['reg_no'] ?? '' }}" required></div>
                                <div class="col-md-4"><label class="form-label">Driver Name / চালকের নাম<span class="text-required">*</span></label><input type="text" name="vehicles[{{ $vIndex }}][driver_name]" class="form-control" value="{{ $vehicle['driver_name'] ?? '' }}" required></div>
                                <div class="col-md-4"><label class="form-label">Driver Contact / মোবাইল<span class="text-required">*</span></label><input type="text" name="vehicles[{{ $vIndex }}][driver_contact]" class="form-control" value="{{ $vehicle['driver_contact'] ?? '' }}" required></div>
                                <div class="col-md-4"><label class="form-label">License / লাইসেন্স</label><input type="text" name="vehicles[{{ $vIndex }}][driver_license_no]" class="form-control" value="{{ $vehicle['driver_license_no'] ?? '' }}"></div>
                                <div class="col-md-4"><label class="form-label">Driver NID / চালকের এনআইডি</label><input type="text" name="vehicles[{{ $vIndex }}][driver_nid]" class="form-control" value="{{ $vehicle['driver_nid'] ?? '' }}"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- STEP 5: FINALIZATION --}}
                <div class="card form-card border-top border-success border-4">
                    <div class="section-title border-bottom pb-2 mb-4"><span class="step-badge">5</span> Finalize & Submit / সম্পন্ন করুন</div>
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label">Tour Guide / ট্যুর গাইড<span class="text-required">*</span></label>
                            <select name="tour_guide_id" id="guide-select" class="form-control" required>
                                <option value="">-- Search & Choose Guide --</option>
                                @foreach ($guides as $guide)
                                    <option value="{{ $guide->id }}" {{ old('tour_guide_id') == $guide->id ? 'selected' : '' }}>
                                        {{ $guide->name }} ({{ $guide->contact }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-success btn-lg w-100 py-3 fw-bold shadow">
                                <i class="bi bi-file-earmark-pdf me-2"></i> SUBMIT & PAY / জমা দিন ও পেমেন্ট করুন
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SIDEBAR --}}
            <div class="col-lg-4">
    <div class="sticky-top" style="top: 20px;">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="bg-success p-4 text-white text-center">
                <h5 class="mb-0 fw-bold">Payment Summary / পেমেন্ট সারসংক্ষেপ</h5>
            </div>
            <div class="card-body p-4 bg-white">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Unit Fee (Adult) / ফি (প্রাপ্তবয়স্ক)</span>
                    <span class="fw-bold">৳{{ number_format($adultFee, 2) }}</span>
                </div>
                <hr class="my-3 opacity-10">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Total Members / মোট সদস্য</span>
                    <span id="total_members_count" class="fw-bold text-dark">0</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted small">Chargeable / ফি প্রযোজ্য</span>
                    <span id="adult_members_count" class="fw-bold text-success">0</span>
                </div>
                <div class="bg-light p-3 rounded-3 mt-4 border border-success-subtle">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-bold text-dark d-block" style="font-size: 0.9rem;">Total Payable</span>
                            <span class="text-muted" style="font-size: 0.75rem;">মোট প্রদেয়</span>
                        </div>
                        <h3 class="text-success mb-0 fw-bold">৳<span id="grand_total">0</span></h3>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <small class="text-muted italic" style="font-size: 0.7rem;">
                        <i class="bi bi-shield-check"></i> Secure Payment Processing / নিরাপদ পেমেন্ট ব্যবস্থা
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    const adultFee = {{ $adultFee }};

    $(document).ready(function() {
        // Initialize Destinations - MULTI SELECT FIX (NO CTRL)
        $('#destination-select').select2({
            theme: 'bootstrap-5',
            placeholder: "Click to select destinations...",
            allowClear: true,
            closeOnSelect: false,
            width: '100%'
        });

        // Initialize Guide Search
        $('#guide-select').select2({
            theme: 'bootstrap-5',
            placeholder: "-- Search & Choose Guide --",
            allowClear: true,
            width: '100%'
        });

        calculateTotal();
    });

    function calculateTotal() {
        const rows = document.querySelectorAll('.member-row');
        const isDefense = document.getElementById('is_defense').checked;
        let adultCount = 0;
        rows.forEach(row => {
            const cat = row.querySelector('.age-category-select');
            if (cat && cat.value === 'Adult') adultCount++;
        });
        let payableCount = isDefense ? 1 : adultCount;
        document.getElementById('total_members_count').innerText = rows.length;
        document.getElementById('adult_members_count').innerText = isDefense ? "1 (Defense Policy)" : adultCount;
        document.getElementById('grand_total').innerText = (payableCount * adultFee).toLocaleString();
    }

    function reIndexRows(containerSelector, rowSelector, namePrefix) {
        $(containerSelector).find(rowSelector).each(function(index, row) {
            $(row).find('input, select').each(function() {
                const name = $(this).attr('name');
                if (name) {
                    const newName = name.replace(new RegExp(`${namePrefix}\\[\\d+\\]`), `${namePrefix}[${index}]`);
                    $(this).attr('name', newName);
                }
            });
        });
    }

    document.getElementById('is_defense').addEventListener('change', calculateTotal);
    $(document).on('change', '.age-category-select', calculateTotal);

    // Member Adding Logic
    document.getElementById('add-member-btn').addEventListener('click', function() {
        const wrapper = document.getElementById('team-members-wrapper');
        const rows = document.querySelectorAll('.member-row');
        const lastRow = rows[rows.length - 1];
        const newRow = lastRow.cloneNode(true);
        const currentIndex = rows.length;

        newRow.querySelectorAll('input').forEach(input => {
            input.value = '';
            const name = input.getAttribute('name');
            if(name) input.setAttribute('name', name.replace(/team\[\d+\]/, `team[${currentIndex}]`));
        });

        newRow.querySelectorAll('select').forEach(select => {
            const name = select.getAttribute('name');
            if(name) select.setAttribute('name', name.replace(/team\[\d+\]/, `team[${currentIndex}]`));
            select.selectedIndex = 0;
        });

        newRow.querySelector('.remove-row').style.display = 'block';
        wrapper.appendChild(newRow);
        calculateTotal();
    });

    $(document).on('click', '.remove-row', function() {
        if ($('.member-row').length > 1) {
            $(this).closest('.member-row').remove();
            reIndexRows('#team-members-wrapper', '.member-row', 'team');
            calculateTotal();
        }
    });

    // Vehicle Adding Logic
    document.getElementById('add-vehicle-btn').addEventListener('click', function() {
        const wrapper = document.getElementById('vehicles-wrapper');
        const rows = document.querySelectorAll('.vehicle-row');
        const lastRow = rows[rows.length - 1];
        const newRow = lastRow.cloneNode(true);
        const currentIndex = rows.length;

        newRow.querySelectorAll('input').forEach(input => {
            input.value = '';
            const name = input.getAttribute('name');
            if(name) input.setAttribute('name', name.replace(/vehicles\[\d+\]/, `vehicles[${currentIndex}]`));
        });

        newRow.querySelectorAll('select').forEach(select => {
            const name = select.getAttribute('name');
            if(name) select.setAttribute('name', name.replace(/vehicles\[\d+\]/, `vehicles[${currentIndex}]`));
            select.selectedIndex = 0;
        });

        newRow.querySelector('.remove-vehicle').style.display = 'block';
        wrapper.appendChild(newRow);
    });

    $(document).on('click', '.remove-vehicle', function() {
        if ($('.vehicle-row').length > 1) {
            $(this).closest('.vehicle-row').remove();
            reIndexRows('#vehicles-wrapper', '.vehicle-row', 'vehicles');
        }
    });

    $('#permitForm').on('submit', function() {
        if($('#destination-select').val().length === 0) {
            alert('Please select at least one destination area.');
            return false;
        }
        return true;
    });
</script>
</body>
</html>