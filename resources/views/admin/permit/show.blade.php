@extends('layouts.admin_master')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.permit.index') }}">Permits</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Permit #{{ $permit->id }}</li>
                        </ol>
                    </nav>
                    <h2 class="fw-bold mb-0 text-dark">Permit Review</h2>
                    <p class="text-muted small mb-0">Full record of application and registered personnel.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.permit.edit', $permit->id) }}" class="btn btn-dashboard">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <button onclick="window.print()" class="btn btn-add">
                        <i class="bi bi-printer"></i> Print Permit
                    </button>
                </div>
            </div>

            <div class="card main-card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3 ps-4">
                    <h6 class="fw-bold mb-0 text-primary uppercase small letter-spacing">Trip Logistics & Status</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <label class="details-label">Group Name</label>
                            <div class="details-value">{{ $permit->group_name }}</div>
                        </div>
                       {{-- Replacement for the Restricted Area Column --}}
<div class="col-md-3">
    <label class="details-label">Restricted Areas</label>
    <div class="details-value">
        @forelse($permit->areas as $area)
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle me-1 mb-1">
                <i class="bi bi-geo-alt-fill small"></i> {{ $area->name }}
            </span>
        @empty
            <span class="text-danger small">No areas selected</span>
        @endforelse
    </div>
</div>
                        <div class="col-md-3">
                            <label class="details-label">Assigned Tour Guide</label>
                            <div class="details-value">{{ $permit->tourGuide->name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-3">
                            <label class="details-label">Permit Status</label>
                            <div>
                                <span class="status-badge {{ $permit->status == 'active' ? 'bg-primary-subtle text-primary' : 'bg-success-subtle text-success' }}">
                                    {{ strtoupper($permit->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="details-label">Arrival Date & Time</label>
                            <div class="details-value-sm">
                                <i class="bi bi-calendar-check me-1"></i>
                                {{ \Carbon\Carbon::parse($permit->arrival_datetime)->format('d M Y, h:i A') }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="details-label">Departure Date & Time</label>
                            <div class="details-value-sm">
                                <i class="bi bi-calendar-x me-1"></i>
                                {{ \Carbon\Carbon::parse($permit->departure_datetime)->format('d M Y, h:i A') }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="details-label">Payment Status</label>
                            <div>
                                <span class="status-badge {{ $permit->payment_status == 1 ? 'bg-info-subtle text-info' : 'bg-warning-subtle text-warning' }}">
                                    {{ $permit->payment_status == 1 ? 'COMPLETED' : 'PENDING' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="details-label">Created At</label>
                            <div class="details-value-sm text-muted">
                                {{ $permit->created_at->format('d M Y, h:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<div class="card mt-4">
    <div class="card-header">
        <h4>Vehicle & Driver Details</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ownership</th>
                    <th>Reg. No</th>
                    <th>Driver Name</th>
                    <th>Contact</th>
                    <th>License / NID</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permit->vehicles as $index => $vehicle)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $vehicle->vehicle_ownership }}</td>
                    <td>{{ $vehicle->vehicle_reg_no }}</td>
                    <td>{{ $vehicle->driver_name }}</td>
                    <td>{{ $vehicle->driver_contact }}</td>
                    <td>
                        <small>
                            Lic: {{ $vehicle->driver_license_no ?? 'N/A' }} <br>
                            NID: {{ $vehicle->driver_nid ?? 'N/A' }}
                        </small>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
            <div class="card main-card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3 ps-4">
                    <h6 class="fw-bold mb-0 text-primary uppercase small letter-spacing">Leader / Point of Contact</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="details-label">Full Name</label>
                            <div class="details-value">{{ $permit->leader_name }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="details-label">NID / Passport</label>
                            <div class="details-value"><code>{{ $permit->leader_nid }}</code></div>
                        </div>
                        <div class="col-md-4">
                            <label class="details-label">Contact Number</label>
                            <div class="details-value">{{ $permit->contact_number }}</div>
                        </div>
                        <div class="col-md-12">
                            <label class="details-label">Email Address</label>
                            <div class="details-value">{{ $permit->email }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card main-card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3 ps-4">
                    <h6 class="fw-bold mb-0 text-primary uppercase small letter-spacing">Team Members List ({{ $permit->teamMembers->count() }})</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Name</th>
                                    <th>Father's Name</th>
                                    <th>Age/Category</th>
                                    <th>Gender</th>
                                    <th>ID Number</th>
                                    <th class="pe-4">Profession</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($permit->teamMembers as $member)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $member->name }}</div>
                                    </td>
                                    <td>{{ $member->fathers_name ?? '---' }}</td>
                                    <td>
                                        <div class="fw-medium">{{ $member->age ?? 'N/A' }} yrs</div>
                                        <span class="badge bg-light text-dark border small">{{ $member->age_category }}</span>
                                    </td>
                                    <td>{{ $member->gender }}</td>
                                    <td><code>{{ $member->nid_or_passport ?? 'N/A' }}</code></td>
                                    <td class="pe-4 text-muted small">{{ $member->profession ?? 'Not specified' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No team members registered.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Modern UI Refinements */
    .main-card { background: #ffffff; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
    .letter-spacing { letter-spacing: 0.05em; }
    .details-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; color: #64748b; display: block; margin-bottom: 4px; }
    .details-value { font-size: 1.1rem; font-weight: 600; color: #1e293b; }
    .details-value-sm { font-size: 0.95rem; font-weight: 500; color: #334155; }
    
    .table thead { background-color: #f8fafc; }
    .table thead th { font-weight: 600; text-transform: uppercase; font-size: 0.7rem; color: #64748b; border: none; padding: 1.25rem 0.5rem; }
    
    .btn-dashboard { background: #f1f5f9; color: #475569; font-weight: 600; border-radius: 8px; border: none; padding: 0.6rem 1.2rem; text-decoration: none; transition: 0.2s; }
    .btn-dashboard:hover { background: #e2e8f0; color: #1e293b; }
    .btn-add { background: #1e293b; color: white; font-weight: 600; border-radius: 8px; padding: 0.6rem 1.2rem; border: none; }
    
    .status-badge { padding: 0.5em 0.8em; border-radius: 6px; font-weight: 700; font-size: 0.75rem; display: inline-block; }

    @media print {
        .btn-dashboard, .btn-add, .breadcrumb, .navbar { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #e2e8f0 !important; }
        body { background: white; }
    }
</style>
@endsection