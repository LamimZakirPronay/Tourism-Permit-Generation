<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Personnel | Tourism System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; }
        .navbar { background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 1rem 0; }
        .btn-dashboard { background: #f1f5f9; color: #475569; font-weight: 600; border: none; border-radius: 8px; padding: 0.5rem 1rem; transition: all 0.2s; }
        .btn-dashboard:hover { background: #e2e8f0; color: #1e293b; }
        .main-card { background: #ffffff; border: none; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .form-label { font-weight: 600; font-size: 0.85rem; color: #475569; }
        .form-control, .form-select { border-radius: 8px; padding: 0.6rem 1rem; border: 1px solid #e2e8f0; transition: all 0.2s; }
        .form-control:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
        .section-title { font-size: 0.95rem; letter-spacing: 0.05em; color: #64748b; margin-bottom: 1.5rem; }
        .security-card { border-radius: 1rem; border-left: 5px solid #ef4444 !important; background: #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
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
                    <button type="submit" class="btn btn-link text-muted text-decoration-none small mt-1">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 mb-5">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-2">
                                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none text-muted">Users</a></li>
                                <li class="breadcrumb-item active fw-semibold">Edit Profile</li>
                            </ol>
                        </nav>
                        <h2 class="fw-bold mb-0">Edit: <span class="text-primary">{{ $user->rank }} {{ $user->name }}</span></h2>
                        <p class="text-muted small mb-0">Update official records and modify system access permissions.</p>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">{{ session('success') }}</div>
                @endif

                <div class="card main-card p-4 p-md-5 mb-4">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="section-title text-uppercase fw-bold border-bottom pb-2">🎖️ Military Identity</div>
                        <div class="row g-4 mb-5">
                            <div class="col-md-4">
                                <label class="form-label">Personal No (BA/BJO/No)</label>
                                <input type="text" name="ba_no" class="form-control" value="{{ old('ba_no', $user->ba_no) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Rank</label>
                                <select name="rank" class="form-select" required>
                                    <optgroup label="Commissioned Officers">
                                        @foreach(['General', 'Lt Gen', 'Maj Gen', 'Brig Gen', 'Col', 'Lt Col', 'Major', 'Captain', 'Lieutenant', '2nd Lt'] as $r)
                                            <option value="{{ $r }}" {{ (old('rank', $user->rank) == $r) ? 'selected' : '' }}>{{ $r }}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="JCOs/NCOs/ORs">
                                        @foreach(['Master Warrant Officer', 'Senior Warrant Officer', 'Warrant Officer', 'Sergeant', 'Corporal', 'Lance Corporal', 'Sainik'] as $r)
                                            <option value="{{ $r }}" {{ (old('rank', $user->rank) == $r) ? 'selected' : '' }}>{{ $r }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Corps</label>
                                <input type="text" name="corps" class="form-control" value="{{ old('corps', $user->corps) }}" required>
                            </div>
                        </div>

                        <div class="section-title text-uppercase fw-bold border-bottom pb-2">📋 Posting & Bio-Data</div>
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Official Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Current Unit</label>
                                <input type="text" name="unit" class="form-control" value="{{ old('unit', $user->unit) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Appointment</label>
                                <input type="text" name="appointment" class="form-control" value="{{ old('appointment', $user->appointment) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Blood Group</label>
                                <select name="blood_group" class="form-select">
                                    <option value="">Select Group</option>
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                        <option value="{{ $bg }}" {{ (old('blood_group', $user->blood_group) == $bg) ? 'selected' : '' }}>{{ $bg }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="section-title text-uppercase fw-bold border-bottom pb-2">🔑 System Access</div>
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <label class="form-label">System Role</label>
                                <select name="role" class="form-select">
                                    <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff Member</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Super Admin</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">New Password (Leave blank to keep current)</label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••">
                            </div>
                        </div>

                        <div class="d-flex align-items-center pt-2">
                            <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold shadow-sm rounded-3">Update Profile</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-link text-muted ms-3 text-decoration-none">Cancel Changes</a>
                        </div>
                    </form>
                </div>

                <div class="card security-card p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-1 text-danger">Two-Factor Authentication (2FA)</h6>
                            <p class="text-muted small mb-0">
                                Current Status: {!! $user->google2fa_secret ? '<span class="text-success fw-bold">Enabled</span>' : 'Not Configured' !!}
                            </p>
                        </div>
                        @if($user->google2fa_secret)
                        <form action="{{ route('admin.users.reset2fa', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm fw-bold px-3" 
                                    onclick="return confirm('Force reset 2FA for this officer? They will need to re-scan the QR code on next login.')">
                                Reset Security Key
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>