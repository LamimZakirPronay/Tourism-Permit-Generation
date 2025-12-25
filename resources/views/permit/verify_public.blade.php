<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Permit #{{ $permit->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .verification-container { max-width: 700px; margin: 30px auto; }
        .card { border: none; border-radius: 15px; overflow: hidden; }
        .header-status { background: linear-gradient(135deg, #198754 0%, #0d6efd 100%); color: white; padding: 40px 20px; }
        .info-label { color: #6c757d; font-size: 0.85rem; text-transform: uppercase; font-weight: 600; }
        .info-value { color: #212529; font-weight: 600; }
        .member-table thead { background-color: #f1f3f5; }
        .status-pill { padding: 8px 20px; border-radius: 50px; font-weight: bold; letter-spacing: 1px; }
        .payment-box { border-left: 5px solid #e2136e; } /* bKash pink color */
    </style>
</head>
<body>

<div class="container verification-container">
    <div class="card shadow-lg">
        <div class="header-status text-center">
            <i class="bi bi-shield-check" style="font-size: 4rem;"></i>
            <h2 class="mt-2 fw-bold">AUTHENTIC PERMIT</h2>
            <div class="mt-3">
                <span class="status-pill bg-white text-success">
                    <i class="bi bi-check-circle-fill"></i> {{ strtoupper($permit->status ?? 'ACTIVE') }}
                </span>
            </div>
        </div>

        <div class="card-body p-4">
            <div class="row mb-4 text-center">
                <div class="col-6 border-end">
                    <div class="info-label">Permit ID</div>
                    <div class="info-value">#{{ $permit->id }}</div>
                </div>
                <div class="col-6">
                    <div class="info-label">Issued On</div>
                    <div class="info-value">{{ $permit->created_at->format('d M Y') }}</div>
                </div>
            </div>

            <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-credit-card-2-back-fill"></i> Payment Information</h5>
            <div class="row g-3 bg-white border rounded p-3 mb-4 payment-box shadow-sm">
                <div class="col-md-4">
                    <div class="info-label">Amount Paid</div>
                    <div class="info-value text-dark">BDT {{ number_format($permit->amount, 2) }}</div>
                </div>
                <div class="col-md-4">
                    <div class="info-label">Method</div>
                    <div class="info-value"><span class="text-danger fw-bold">bKash</span> Online</div>
                </div>
                <div class="col-md-4">
                    <div class="info-label">Transaction ID</div>
                    <div class="info-value text-break"><code>{{ $permit->bkash_trx_id ?? 'N/A' }}</code></div>
                </div>
                <div class="col-12 mt-2">
                    <span class="badge bg-success-subtle text-success border border-success px-3">
                        <i class="bi bi-patch-check"></i> Payment {{ ucfirst($permit->payment_status) }}
                    </span>
                </div>
            </div>

            <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-geo-alt-fill"></i> Trip Details</h5>
            <div class="row g-3 bg-light p-3 rounded mb-4">
                <div class="col-md-6">
                    <div class="info-label">Group Name</div>
                    <div class="info-value">{{ $permit->group_name }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Restricted Area</div>
                    <div class="info-value text-danger">{{ $permit->area_name }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Arrival</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($permit->arrival_datetime)->format('d M Y - h:i A') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Departure</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($permit->departure_datetime)->format('d M Y - h:i A') }}</div>
                </div>
            </div>

            <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-person-badge-fill"></i> Team Leader</h5>
            <div class="row g-3 border rounded p-3 mb-4">
                <div class="col-md-6">
                    <div class="info-label">Full Name</div>
                    <div class="info-value">{{ $permit->leader_name }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">NID/Passport</div>
                    <div class="info-value">{{ $permit->leader_nid }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Contact</div>
                    <div class="info-value">{{ $permit->contact_number }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $permit->email }}</div>
                </div>
            </div>

            <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-people-fill"></i> Team Members ({{ $permit->total_members }})</h5>
            <div class="table-responsive">
                <table class="table member-table table-bordered align-middle small">
                    <thead>
                        <tr>
                            <th>Member Name</th>
                            <th>Gender</th>
                            <th>Category</th>
                            <th>ID Number</th>
                            <th>Blood</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permit->teamMembers as $member)
                        <tr>
                            <td class="fw-bold">{{ $member->name }}</td>
                            <td>{{ $member->gender }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $member->age_category }}</span>
                            </td>
                            <td><code>{{ $member->nid_or_passport }}</code></td>
                            <td class="text-danger fw-bold">{{ $member->blood_group }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 p-3 bg-dark text-white rounded shadow-sm">
                <div class="row align-items-center">
                    <div class="col-2 text-center">
                        <i class="bi bi-person-video3" style="font-size: 2rem;"></i>
                    </div>
                    <div class="col-10">
                        <div class="small text-uppercase opacity-75">Authorized Tour Guide</div>
                        <div class="fw-bold fs-5">{{ $permit->tourGuide->name ?? 'N/A' }}</div>
                        <div class="small">Contact: {{ $permit->tourGuide->contact_number ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer bg-white text-center py-4">
            <p class="text-muted small mb-0">Verified via Secure QR System on {{ now()->format('F j, Y, g:i a') }}</p>
            <div class="mt-2">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/17/Seal_of_Bangladesh.svg/1200px-Seal_of_Bangladesh.svg.png" width="40" alt="Gov Seal">
            </div>
        </div>
    </div>
</div>

</body>
</html>