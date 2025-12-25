@php
    $settings = \App\Models\SiteSetting::pluck('value', 'key');
    $adultFee = $adultFee ?? 0;
    $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
    $oldTeam = old('team', [[]]); 
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourism Permit Application</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
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
        .member-card { 
            border: 1px solid #e2e8f0; border-left: 6px solid var(--soft-green); 
            border-radius: 12px; background: #ffffff !important; padding: 1.5rem !important; margin-bottom: 1.5rem; position: relative;
        }
        .remove-row { top: -10px; right: -10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); z-index: 10; }
        .form-label { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.4rem; font-weight: 700; }
        .text-required { color: #dc3545; margin-left: 2px; }
        .help-text { font-size: 0.75rem; color: #6c757d; margin-top: 0.25rem; display: block; }
        .main-title-container { background: rgba(255, 255, 255, 0.95); padding: 20px 60px; border-radius: 100px; display: inline-flex; align-items: center; gap: 30px; min-width: 60%; backdrop-filter: blur(10px); }
        
        /* CONSISTENCY FIXES */
        .form-control, .form-select {
            height: 38px !important;
            border: 1px solid #dee2e6 !important;
            border-radius: 0.375rem !important;
            font-size: 0.9rem;
        }
        input[type="file"].form-control {
            line-height: 24px; /* Adjusts text centering for file inputs */
        }
        /* Select2 Matching */
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #dee2e6 !important;
            border-radius: 0.375rem !important;
            min-height: 38px !important; 
            padding: 0 4px !important;
            display: flex !important;
            align-items: center !important;
            background-color: #fff !important;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #86b7fe !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
            outline: 0 !important;
        }
        .select2-container { width: 100% !important; }
    </style>
</head>
<body>

<div class="container my-5">
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-exclamation-octagon-fill me-2 fs-5"></i>
                <strong class="fs-6">Validation Errors:</strong>
            </div>
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="text-center mb-5">
        <div class="main-title-container shadow-lg border border-white border-2">
            @if(isset($settings['site_logo']))
                <div class="logo-wrapper" style="border-right: 2px solid #e2e8f0; padding-right: 25px;">
                    <img src="{{ $settings['site_logo'] }}"  
                         alt="Site Logo" 
                         style="height: 70px; width: auto; object-fit: contain;"
                         onerror="this.src='https://placehold.co/100x100?text=Logo';">
                </div>
            @endif
            
            <div class="text-start">
                <h1 class="text-success fw-bold mb-0" style="font-size: 2.2rem; letter-spacing: -0.5px; line-height: 1.2;">
                    {{ $settings['site_name'] ?? 'Tourism Entry Permit' }}
                </h1>
                <div class="d-flex align-items-center mt-1">
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1.5px;">
                        Managed by Bangladesh Army (সুদৃঢ় ছত্রিশ)
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
                        <span class="step-badge">1</span> Trip Details
                    </div>
                    <div class="card-body p-0">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Group Name<span class="text-required">*</span></label>
                                <input type="text" class="form-control" name="group_name" value="{{ old('group_name') }}" required placeholder="Enter group alias">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Destination Areas<span class="text-required">*</span></label>
                                <select name="area_ids[]" id="area_ids" class="form-control select2-multiple" multiple="multiple" required>
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}" {{ (is_array(old('area_ids')) && in_array($area->id, old('area_ids'))) ? 'selected' : '' }}>{{ $area->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Arrival Date & Time<span class="text-required">*</span></label>
                                <input type="datetime-local" class="form-control" name="arrival_datetime" value="{{ old('arrival_datetime') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Departure Date & Time<span class="text-required">*</span></label>
                                <input type="datetime-local" class="form-control" name="departure_datetime" value="{{ old('departure_datetime') }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 2: LEAD APPLICANT --}}
                <div class="card form-card">
                    <div class="section-title border-bottom pb-2 mb-4"><span class="step-badge">2</span> Lead Applicant</div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Leader Full Name<span class="text-required">*</span></label>
                            <input type="text" class="form-control" name="leader_name" value="{{ old('leader_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Leader NID / Passport<span class="text-required">*</span></label>
                            <input type="text" class="form-control" name="leader_nid" value="{{ old('leader_nid') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address<span class="text-required">*</span></label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact Number<span class="text-required">*</span></label>
                            <input type="text" class="form-control" name="contact_number" value="{{ old('contact_number') }}" required>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch p-3 border rounded-3 bg-light d-flex align-items-center">
                                <input class="form-check-input ms-0 me-3" type="checkbox" name="is_defense" id="is_defense" value="1" {{ old('is_defense') ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold text-primary" for="is_defense">
                                    <i class="bi bi-shield-check me-1"></i> Is the Leader a Defense Personnel?
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Support Documents (PDF Only)<span class="text-required">*</span></label>
                            <input type="file" class="form-control" name="document" accept=".pdf" required>
                            <span class="help-text">Upload NID/Passport copies.</span>
                        </div>
                    </div>
                </div>

                {{-- STEP 4: TEAM MEMBERS --}}
                <div class="card form-card">
                    <div class="section-title justify-content-between border-bottom pb-2 mb-4">
                        <div><span class="step-badge">4</span> Team Members</div>
                        <button type="button" id="add-member-btn" class="btn btn-success btn-sm rounded-pill px-3"><i class="bi bi-person-plus"></i> Add Member</button>
                    </div>
                    
                    <div id="team-members-wrapper">
                        @foreach($oldTeam as $index => $member)
                        <div class="member-card member-row">
                            <button type="button" class="btn btn-danger btn-sm rounded-circle remove-row position-absolute" style="{{ $index == 0 ? 'display:none;' : '' }}"><i class="bi bi-x"></i></button>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Full Name<span class="text-required">*</span></label>
                                    <input type="text" name="team[{{ $index }}][name]" value="{{ $member['name'] ?? '' }}" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Father's Name<span class="text-required">*</span></label>
                                    <input type="text" name="team[{{ $index }}][fathers_name]" value="{{ $member['fathers_name'] ?? '' }}" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Age<span class="text-required">*</span></label>
                                    <input type="number" name="team[{{ $index }}][age]" value="{{ $member['age'] ?? '' }}" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Gender<span class="text-required">*</span></label>
                                    <select name="team[{{ $index }}][gender]" class="form-select" required>
                                        @foreach(['Male', 'Female', 'Other'] as $g)
                                            <option value="{{ $g }}" {{ ($member['gender'] ?? '') == $g ? 'selected' : '' }}>{{ $g }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Category<span class="text-required">*</span></label>
                                    <select name="team[{{ $index }}][age_category]" class="form-select age-category-select" required>
                                        @foreach(['Adult', 'Children', 'Infant'] as $cat)
                                            <option value="{{ $cat }}" {{ ($member['age_category'] ?? '') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">NID / Passport<span class="text-required">*</span></label>
                                    <input type="text" name="team[{{ $index }}][id]" value="{{ $member['id'] ?? '' }}" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Blood Group<span class="text-required">*</span></label>
                                    <select name="team[{{ $index }}][blood_group]" class="form-select" required>
                                        <option value="">Select Group</option>
                                        @foreach($bloodGroups as $bg)
                                            <option value="{{ $bg }}" {{ ($member['blood_group'] ?? '') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Contact No.<span class="text-required">*</span></label>
                                    <input type="text" name="team[{{ $index }}][contact_number]" value="{{ $member['contact_number'] ?? '' }}" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Emergency Contact<span class="text-required">*</span></label>
                                    <input type="text" name="team[{{ $index }}][emergency_contact]" value="{{ $member['emergency_contact'] ?? '' }}" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Profession (Optional)</label>
                                    <input type="text" name="team[{{ $index }}][profession]" value="{{ $member['profession'] ?? '' }}" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Permanent Address<span class="text-required">*</span></label>
                                    <input type="text" name="team[{{ $index }}][address]" value="{{ $member['address'] ?? '' }}" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- STEP 3: DRIVER & VEHICLE --}}
                <div class="card form-card">
                    <div class="section-title border-bottom pb-2 mb-4"><span class="step-badge">3</span> Driver & Vehicle</div>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label">Vehicle Ownership<span class="text-required">*</span></label>
                            <select name="vehicle_ownership" class="form-select" required>
                                <option value="Local Car" {{ old('vehicle_ownership') == 'Local Car' ? 'selected' : '' }}>Local Car (Chander Gari)</option>
                                <option value="Personal Car" {{ old('vehicle_ownership') == 'Personal Car' ? 'selected' : '' }}>Personal Car</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Registration No.<span class="text-required">*</span></label>
                            <input type="text" name="vehicle_reg_no" class="form-control" value="{{ old('vehicle_reg_no') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Driver Name<span class="text-required">*</span></label>
                            <input type="text" name="driver_name" class="form-control" value="{{ old('driver_name') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Driver Contact<span class="text-required">*</span></label>
                            <input type="text" name="driver_contact" class="form-control" value="{{ old('driver_contact') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Driver License (Optional)</label>
                            <input type="text" name="driver_license_no" class="form-control" value="{{ old('driver_license_no') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Driver NID (Optional)</label>
                            <input type="text" name="driver_nid" class="form-control" value="{{ old('driver_nid') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Driver Emergency Contact (Optional)</label>
                            <input type="text" name="driver_emergency_contact" class="form-control" value="{{ old('driver_emergency_contact') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Driver Blood Group (Optional)</label>
                            <select name="driver_blood_group" class="form-select">
                                <option value="">Select</option>
                                @foreach($bloodGroups as $bg)
                                    <option value="{{ $bg }}" {{ old('driver_blood_group') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- STEP 5: FINALIZATION --}}
                <div class="card form-card border-top border-success border-4">
                    <div class="section-title border-bottom pb-2 mb-4"><span class="step-badge">5</span> Finalize & Submit</div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Allocated Tour Guide<span class="text-required">*</span></label>
                            <select class="form-select" name="tour_guide_id" required>
                                <option value="">-- Choose Guide --</option>
                                @foreach ($guides as $guide)
                                    <option value="{{ $guide->id }}" {{ old('tour_guide_id') == $guide->id ? 'selected' : '' }}>{{ $guide->name }} ({{ $guide->phone }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-success btn-lg w-100 py-3 fw-bold shadow">
                                <i class="bi bi-file-earmark-pdf me-2"></i> Submit & Pay via bKash
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
                            <h5 class="mb-0 fw-bold">Payment Summary</h5>
                        </div>
                        <div class="card-body p-4 bg-white">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Unit Fee (Adult)</span>
                                <span class="fw-bold">৳{{ number_format($adultFee, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total Members</span>
                                <span id="total_members_count" class="fw-bold">0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Chargeable Adults</span>
                                <span id="adult_members_count" class="fw-bold text-success">0</span>
                            </div>
                            <div class="bg-light p-3 rounded-3 mt-4 border">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">Total Payable</span>
                                    <h3 class="text-success mb-0 fw-bold">৳<span id="grand_total">0</span></h3>
                                </div>
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
    let memberCount = {{ count($oldTeam) }};

    $(document).ready(function() {
        $('.select2-multiple').select2({ width: '100%', placeholder: "Select destinations..." });
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

    document.getElementById('is_defense').addEventListener('change', calculateTotal);

    document.getElementById('add-member-btn').addEventListener('click', function() {
        const wrapper = document.getElementById('team-members-wrapper');
        const firstRow = document.querySelector('.member-row');
        const newRow = firstRow.cloneNode(true);
        
        newRow.querySelectorAll('input').forEach(input => {
            input.value = '';
            const name = input.getAttribute('name');
            if(name) input.setAttribute('name', name.replace(/team\[\d+\]/, `team[${memberCount}]`));
        });

        newRow.querySelectorAll('select').forEach(select => {
            const name = select.getAttribute('name');
            if(name) select.setAttribute('name', name.replace(/team\[\d+\]/, `team[${memberCount}]`));
            select.selectedIndex = 0;
        });

        newRow.querySelector('.remove-row').style.display = 'block';
        wrapper.appendChild(newRow);
        memberCount++;
        calculateTotal();
    });

    $(document).on('click', '.remove-row', function() {
        if ($('.member-row').length > 1) {
            $(this).closest('.member-row').remove();
            calculateTotal();
        }
    });

    $(document).on('change', '.age-category-select', calculateTotal);
</script>



</body>
</html>

<script>
    // ১. রাইট ক্লিক বন্ধ করা
    document.addEventListener('contextmenu', e => e.preventDefault());

    // ২. গুরুত্বপূর্ণ কী-বোর্ড শর্টকাট ব্লক করা
    document.onkeydown = function(e) {
        // F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U
        if (e.keyCode == 123 || 
            (e.ctrlKey && e.shiftKey && (e.keyCode == 73 || e.keyCode == 74)) || 
            (e.ctrlKey && e.keyCode == 85)) {
            return false;
        }
    };

    // ৩. কন্টিনিউয়াস লোডিং সমস্যা সমাধানের জন্য ডিবাগার ট্র্যাপের আধুনিক ভার্সন
    // এটি শুধুমাত্র তখনই ট্রিগার হবে যখন কেউ ইন্সপেক্ট উইন্ডো ওপেন করবে
    (function() {
        var element = new Image();
        Object.defineProperty(element, 'id', {
            get: function() {
                // ইন্সপেক্ট খুললে এটি কনসোলে প্রিন্ট হওয়ার চেষ্টা করবে এবং পেজ রিডাইরেক্ট করবে
                window.location.href = "{{ route('admin.dashboard') }}";
            }
        });
        console.log(element);
    })();

    // ৪. কনসোল উইন্ডো ডিটেক্ট করার লাইটওয়েট পদ্ধতি
    let devtools = { isOpen: false };
    const threshold = 160;
    setInterval(() => {
        const widthThreshold = window.outerWidth - window.innerWidth > threshold;
        const heightThreshold = window.outerHeight - window.innerHeight > threshold;
        if (widthThreshold || heightThreshold) {
            if (!devtools.isOpen) {
                console.clear();
                console.log("%cSecurity Active: Inspecting is restricted.", "color: red; font-size: 20px;");
            }
            devtools.isOpen = true;
        } else {
            devtools.isOpen = false;
        }
    }, 1000);
</script>