@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm mx-auto mt-4 container rounded-4">
        <div class="d-flex align-items-center mb-2">
            <i class="bi bi-exclamation-octagon-fill me-2 fs-5"></i>
            <strong class="fs-6">Please correct the following errors:</strong>
        </div>
        <ul class="mb-0 small">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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
            background: linear-gradient(rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.3)), 
                        url('https://images.unsplash.com/photo-1660703080906-f4ac0cb7ea43?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');

                        
            background-size: cover; background-attachment: fixed; color: #1e293b;
        }
        .form-card { 
            background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(15px); 
            border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0,0,0,0.08); 
            margin-bottom: 2rem; padding: 2.5rem !important;
        }
        .step-badge {
            background-color: var(--forest-green); color: white; width: 32px; height: 32px;
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 50%; margin-right: 12px; font-weight: bold;
        }
        .section-title { font-size: 1.4rem; font-weight: 800; color: var(--forest-green); margin-bottom: 2rem; display: flex; align-items: center; }
        .member-card { 
            border: 1px solid #e2e8f0; border-left: 6px solid var(--soft-green); 
            border-radius: 12px; background: #ffffff !important; padding: 1.5rem !important; margin-bottom: 1.5rem; position: relative;
        }
        .remove-row { top: -10px; right: -10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .form-label { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.025em; color: #64748b; margin-bottom: 0.5rem; font-weight: 700; }
        .form-control, .form-select { border: 1.5px solid #e2e8f0; padding: 0.75rem 1rem; }
        .sticky-summary { position: sticky; top: 20px; }
        .main-title { background: rgba(255, 255, 255, 0.9); padding: 15px 40px; border-radius: 100px; }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="text-center mb-5">
        <h1 class="main-title text-success fw-bold d-inline-flex align-items-center">
          @if(isset($settings['site_logo']))
                            <img src="{{ $settings['site_logo'] }}" style="height: 55px; width: auto;">
                        @endif
                         Ruma Tourist Entry Permit
        </h1>
    </div>

    <form action="{{ route('permit.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            <div class="col-lg-8">
                
                {{-- STEP 1: TRIP DETAILS --}}
                <div class="card form-card">
                    <div class="section-title"><span class="step-badge">1</span> Trip Details</div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Group Name</label>
                            <input type="text" class="form-control" name="group_name" value="{{ old('group_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Select Restricted Areas</label>
                            <select name="area_ids[]" id="area_ids" class="form-control select2-multiple" multiple="multiple" required>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}" {{ (is_array(old('area_ids')) && in_array($area->id, old('area_ids'))) ? 'selected' : '' }}>{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Arrival Date & Time</label>
                            <input type="datetime-local" class="form-control" name="arrival_datetime" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Departure Date & Time</label>
                            <input type="datetime-local" class="form-control" name="departure_datetime" required>
                            <small class="text-danger fw-bold"><i class="bi bi-clock"></i> Must be before 5:00 PM</small>
                        </div>
                    </div>
                </div>

                {{-- STEP 2: LEAD APPLICANT --}}
                <div class="card form-card">
                    <div class="section-title"><span class="step-badge">2</span> Lead Applicant</div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="leader_name" value="{{ old('leader_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NID / Passport Number</label>
                            <input type="text" class="form-control" name="leader_nid" value="{{ old('leader_nid') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input type="text" class="form-control" name="contact_number" value="{{ old('contact_number') }}" required>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch p-3 border rounded-3 bg-light">
                                <input class="form-check-input ms-0 me-3" type="checkbox" name="is_defense" id="is_defense" value="1">
                                <label class="form-check-label fw-bold text-primary" for="is_defense">
                                    <i class="bi bi-shield-check me-1"></i> Is the Leader a Defense Personnel?
                                </label>
                                <small class="d-block text-muted">If checked, a flat fee for only 1 person will be charged for the entire group.</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 3: DRIVER & VEHICLE --}}
                <div class="card form-card">
                    <div class="section-title"><span class="step-badge">3</span> Driver & Vehicle</div>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label">Vehicle Ownership</label>
                            <select name="vehicle_ownership" class="form-select" required>
                                <option value="Local Car">Local Car (Rental)</option>
                                <option value="Personal Car">Personal Car (Private)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Vehicle Registration No.</label>
                            <input type="text" name="vehicle_reg_no" class="form-control" placeholder="e.g. Dhaka Metro-GA-11" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Driver's Name</label>
                            <input type="text" name="driver_name" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Driver Contact</label>
                            <input type="text" name="driver_contact" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Driver License No.</label>
                            <input type="text" name="driver_license_no" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Driver NID</label>
                            <input type="text" name="driver_nid" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Driver Emergency Contact</label>
                            <input type="text" name="driver_emergency_contact" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Driver Blood Group</label>
                            <select name="driver_blood_group" class="form-select">
                                <option value="">Select</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $group)
                                    <option value="{{ $group }}">{{ $group }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- STEP 4: TEAM MEMBERS --}}
                <div class="card form-card">
                    <div class="section-title justify-content-between">
                        <div><span class="step-badge">4</span> Team Members</div>
                        <button type="button" id="add-member-btn" class="btn btn-success btn-sm rounded-pill px-3"><i class="bi bi-person-plus"></i> Add Member</button>
                    </div>
                    
                    <div id="team-members-wrapper">
                        <div class="member-card member-row">
                            <button type="button" class="btn btn-danger btn-sm rounded-circle remove-row position-absolute" style="display:none;"><i class="bi bi-x"></i></button>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="team[0][name]" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Father's Name</label>
                                    <input type="text" name="team[0][fathers_name]" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Age</label>
                                    <input type="number" name="team[0][age]" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Gender</label>
                                    <select name="team[0][gender]" class="form-select" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Category</label>
                                    <select name="team[0][age_category]" class="form-select age-category-select" required>
                                        <option value="Adult">Adult</option>
                                        <option value="Children">Children</option>
                                        <option value="Infant">Infant</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">NID/Passport</label>
                                    <input type="text" name="team[0][id]" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Blood Group</label>
                                    <input type="text" name="team[0][blood_group]" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Profession</label>
                                    <input type="text" name="team[0][profession]" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Contact</label>
                                    <input type="text" name="team[0][contact_number]" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Emergency Contact</label>
                                    <input type="text" name="team[0][emergency_contact]" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Full Address</label>
                                    <input type="text" name="team[0][address]" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 5: DOCUMENTS --}}
                <div class="card form-card border-success border-2">
                    <div class="section-title"><span class="step-badge">5</span> Verification</div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Tour Guide</label>
                            <select class="form-select" name="tour_guide_id" required>
                                <option value="">-- Select Guide --</option>
                                @foreach ($guides as $guide)
                                    <option value="{{ $guide->id }}">{{ $guide->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-danger">Upload Documents (PDF)</label>
                            <input type="file" class="form-control border-danger" name="document" accept=".pdf" required>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-success btn-lg w-100 py-3 fw-bold shadow-lg">Submit & Generate PDF</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SIDEBAR --}}
            <div class="col-lg-4">
                <div class="sticky-summary">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="bg-success p-4 text-white">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-receipt me-2"></i> Payment Summary</h5>
                        </div>
                        <div class="card-body p-4 bg-white">
                            <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                                <span class="text-muted small">Adult Fee</span>
                                <span class="fw-bold text-success">৳{{ number_format($adultFee, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Total Members</span>
                                <span id="total_members_count" class="fw-bold">1</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Payable Adults</span>
                                <span id="adult_members_count" class="fw-bold text-primary">1</span>
                            </div>
                            <div class="bg-light p-3 rounded-3 mt-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">Total Amount</span>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    const adultFee = {{ $adultFee }};
    let memberCount = 1;

    $(document).ready(function() {
        $('.select2-multiple').select2({ width: '100%', allowClear: true, closeOnSelect: false });
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

        // Logic: If defense is checked, we only charge for 1 adult fee total.
        let payableCount = isDefense ? 1 : adultCount;
        
        document.getElementById('total_members_count').innerText = rows.length;
        document.getElementById('adult_members_count').innerText = isDefense ? "1 (Defense Policy)" : adultCount;
        document.getElementById('grand_total').innerText = (payableCount * adultFee).toLocaleString();
    }

    // Listener for Defense Checkbox
    document.getElementById('is_defense').addEventListener('change', calculateTotal);

    document.getElementById('add-member-btn').addEventListener('click', function() {
        const wrapper = document.getElementById('team-members-wrapper');
        const firstRow = document.querySelector('.member-row');
        const newRow = firstRow.cloneNode(true);
        newRow.querySelectorAll('input, select').forEach(input => {
            input.value = '';
            input.name = input.name.replace(/team\[\d+\]/, `team[${memberCount}]`);
            if(input.name.includes('gender')) input.value = 'Male';
            if(input.name.includes('age_category')) input.value = 'Adult';
        });
        newRow.querySelector('.remove-row').style.display = 'block';
        wrapper.appendChild(newRow);
        memberCount++;
        calculateTotal();
    });

    document.addEventListener('click', (e) => { 
        if (e.target.closest('.remove-row')) { 
            e.target.closest('.member-row').remove(); 
            calculateTotal(); 
        } 
    });

    document.addEventListener('change', (e) => { 
        if (e.target.classList.contains('age-category-select')) {
            calculateTotal(); 
        }
    });
</script>
</body>
</html>