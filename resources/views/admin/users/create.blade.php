<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Personnel | Tourism System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; }
        .navbar { background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 1rem 0; }
        .btn-dashboard { background: #f1f5f9; color: #475569; font-weight: 600; border: none; border-radius: 8px; padding: 0.5rem 1rem; }
        .main-card { background: #ffffff; border: none; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .form-label { font-weight: 600; font-size: 0.85rem; color: #475569; }
        .form-control, .form-select { border-radius: 8px; padding: 0.6rem 1rem; border: 1px solid #e2e8f0; transition: all 0.2s; }
        .form-control:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
        .section-title { font-size: 0.95rem; letter-spacing: 0.05em; color: #64748b; margin-bottom: 1.5rem; }
    </style>
</head>
<body>

    <nav class="navbar mb-5 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">Tourism System</a>
            <div class="d-flex align-items-center">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-dashboard d-flex align-items-center me-3">
                    <i class="bi bi-grid-fill me-2"></i> Dashboard
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link text-muted text-decoration-none small">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 mb-5">
                <div class="mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none text-muted">Users</a></li>
                            <li class="breadcrumb-item active fw-semibold">New Registration</li>
                        </ol>
                    </nav>
                    <h2 class="fw-bold mb-0 text-dark">Register New Personnel</h2>
                    <p class="text-muted small mb-0">Complete all fields to initialize the military system profile.</p>
                </div>

                <div class="card main-card p-4 p-md-5">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        
                        <div class="section-title text-uppercase fw-bold border-bottom pb-2">🎖️ Military Identity</div>
                        <div class="row g-4 mb-5">
                            <div class="col-md-4">
                                <label class="form-label">Personal No (BA/BJO/No)</label>
                                <input type="text" name="ba_no" class="form-control" placeholder="e.g. BA-1234" value="{{ old('ba_no') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Rank</label>
                                <select name="rank" class="form-select" required>
                                    <option value="">Select Rank</option>
                                    <optgroup label="Commissioned Officers">
                                        <option>General</option><option>Lt Gen</option><option>Maj Gen</option><option>Brig Gen</option>
                                        <option>Col</option><option>Lt Col</option><option>Major</option><option>Captain</option>
                                        <option>Lieutenant</option><option>2nd Lt</option>
                                    </optgroup>
                                    <optgroup label="JCOs/NCOs/ORs">
                                        <option>Master Warrant Officer</option><option>Senior Warrant Officer</option>
                                        <option>Warrant Officer</option><option>Sergeant</option>
                                        <option>Corporal</option><option>Lance Corporal</option><option>Sainik</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Corps</label>
                                <input type="text" name="corps" class="form-control" placeholder="e.g. Infantry / ASC" value="{{ old('corps') }}" required>
                            </div>
                        </div>

                        <div class="section-title text-uppercase fw-bold border-bottom pb-2">📋 Posting & Bio-Data</div>
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name as per Service Record" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Official Email</label>
                                <input type="email" name="email" class="form-control" placeholder="officer@army.mil.bd" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Current Unit</label>
                                <input type="text" name="unit" class="form-control" placeholder="e.g. 12 Bengal" value="{{ old('unit') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Appointment</label>
                                <input type="text" name="appointment" class="form-control" placeholder="e.g. Adjutant / QM" value="{{ old('appointment') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Blood Group</label>
                                <select name="blood_group" class="form-select">
                                    <option value="">Select Group</option>
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                        <option value="{{ $bg }}">{{ $bg }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="section-title text-uppercase fw-bold border-bottom pb-2">🔑 System Access</div>
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <label class="form-label">System Role</label>
                                <select name="role" class="form-select">
                                    <option value="staff">Staff Member (Data Entry)</option>
                                    <option value="admin">Super Admin (Management)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Account Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Minimum 8 characters" required>
                            </div>
                        </div>

                        <div class="d-flex align-items-center pt-3">
                            <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold shadow-sm rounded-3">Register Personnel</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-link text-muted ms-3 text-decoration-none">Discard Changes</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>