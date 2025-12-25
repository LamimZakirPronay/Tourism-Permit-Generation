<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourism Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; }
        .navbar { background: #0f172a !important; padding: 1rem 0; }
        .stat-card { border: none; border-radius: 12px; transition: transform 0.2s; position: relative; overflow: hidden; }
        .stat-card:hover { transform: translateY(-5px); }
        .revenue-gradient { background: linear-gradient(135deg, #1e293b 0%, #334155 100%); color: white; }
        .icon-box { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 8px; }
        .chart-container { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .card-title-sm { font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: #64748b; margin-bottom: 0.5rem; }
        
        .bg-info-subtle { background-color: #e0f2fe !important; }
        .text-info-custom { color: #0369a1 !important; }
        .bg-primary-subtle { background-color: #eef2ff !important; }
        .bg-success-subtle { background-color: #f0fdf4 !important; }
        .bg-warning-subtle { background-color: #fffbeb !important; }
        .bg-danger-subtle { background-color: #fef2f2 !important; }
        .bg-light-subtle { background-color: #fafafa !important; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark mb-4 shadow-sm">
    <div class="container">
        <span class="navbar-brand fw-bold"><i class="bi bi-compass me-2 text-primary"></i>Tourism Admin Panel</span>
        <div class="d-flex align-items-center">
            <span class="text-white-50 me-3 small d-none d-md-inline">Welcome, {{ auth()->user()->name }}</span>
            
            @if(auth()->user()->role == 'admin')
            <a href="{{ route('admin.settings.edit') }}" class="btn btn-outline-light btn-sm rounded-circle me-2" title="Site Settings">
                <i class="bi bi-gear"></i>
            </a>
            @endif

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-light btn-sm rounded-pill px-3">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container pb-5">
    {{-- Statistics Cards Row --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card revenue-gradient shadow-sm p-3">
                <div class="card-title-sm text-white opacity-75">Total Revenue</div>
                <h2 class="fw-bold mb-0">৳{{ number_format($totalRevenue, 2) }}</h2>
                <div class="mt-2 small opacity-75"><i class="bi bi-wallet2 me-1"></i> Lifetime Collections</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-white shadow-sm p-3 border-start border-primary border-4">
                <div class="card-title-sm">Total Visitors</div>
                <h2 class="fw-bold mb-0 text-dark">{{ number_format($totalVisitors) }}</h2>
                <div class="mt-2 small text-primary fw-semibold"><i class="bi bi-people-fill me-1"></i> Registered Members</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-white shadow-sm p-3 border-start border-warning border-4">
                <div class="card-title-sm text-warning">Currently Inside</div>
                <h2 class="fw-bold mb-0 text-dark">{{ $permitStats['inside'] }}</h2>
                <div class="mt-2 small text-muted"><i class="bi bi-geo-alt-fill me-1"></i> Active Permit Groups</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-white shadow-sm p-3 border-start border-success border-4">
                <div class="card-title-sm text-success">Safely Exited</div>
                <h2 class="fw-bold mb-0 text-dark">{{ $permitStats['exited'] }}</h2>
                <div class="mt-2 small text-muted"><i class="bi bi-shield-check-fill me-1"></i> Completed Trips</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Chart Section --}}
        <div class="col-lg-8">
            <div class="chart-container h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0 text-dark">Financial Performance</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border px-3" type="button">Monthly View</button>
                    </div>
                </div>
                <div style="height: 300px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Resource Management Sidebar --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h5 class="fw-bold mb-4 text-dark">Resources Management</h5>
                
                @if(auth()->user()->role == 'admin')
                {{-- User Control --}}
                <div class="d-flex align-items-center p-3 mb-3 rounded-3 border bg-light-subtle shadow-sm">
                    <div class="icon-box bg-primary-subtle text-primary me-3"><i class="bi bi-people-fill fs-5"></i></div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold small">User Control</h6>
                        <small class="text-muted">{{ $counts['users'] }} System Users</small>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary rounded-pill px-3">Go</a>
                </div>

                {{-- Site Settings --}}
                <div class="d-flex align-items-center p-3 mb-3 rounded-3 border bg-info-subtle shadow-sm">
                    <div class="icon-box bg-white text-info-custom me-3"><i class="bi bi-sliders fs-5"></i></div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold small">Site Settings</h6>
                        <small class="text-muted">Logo, Fees & Info</small>
                    </div>
                    <a href="{{ route('admin.settings.edit') }}" class="btn btn-sm btn-info text-white rounded-pill px-3" style="background-color: #0ea5e9;">Edit</a>
                </div>

                {{-- Restricted Areas (New Section) --}}
                <div class="d-flex align-items-center p-3 mb-3 rounded-3 border bg-danger-subtle shadow-sm">
                    <div class="icon-box bg-white text-danger me-3"><i class="bi bi-map-fill fs-5"></i></div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold small">Restricted Areas</h6>
                        <small class="text-muted">Manage Entry Locations</small>
                    </div>
                    <a href="{{ route('admin.areas.index') }}" class="btn btn-sm btn-danger rounded-pill px-3">Entry</a>
                </div>
                @endif

                {{-- Tour Guides --}}
                <div class="d-flex align-items-center p-3 mb-3 rounded-3 border bg-light-subtle shadow-sm">
                    <div class="icon-box bg-success-subtle text-success me-3"><i class="bi bi-person-badge-fill fs-5"></i></div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold small">Tour Guides</h6>
                        <small class="text-muted">{{ $counts['guides'] }} Active</small>
                    </div>
                    <a href="{{ route('admin.guides.index') }}" class="btn btn-sm btn-success rounded-pill px-3">Go</a>
                </div>

                {{-- Driver Section --}}
                <div class="d-flex align-items-center p-3 mb-3 rounded-3 border bg-light-subtle shadow-sm">
                    <div class="icon-box bg-warning-subtle text-warning me-3"><i class="bi bi-truck fs-5"></i></div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold small">Driver Section</h6>
                        <small class="text-muted">{{ $counts['drivers'] }} Records</small>
                    </div>
                    <a href="{{ route('admin.drivers.index') }}" class="btn btn-sm btn-warning rounded-pill px-3">Go</a>
                </div>

                <a href="{{ route('admin.permit.index') }}" class="btn btn-dark w-100 py-3 fw-bold rounded-3 shadow-sm mt-auto">
                    <i class="bi bi-file-earmark-text me-2"></i>Review All Permits
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyRevenue->pluck('month')) !!},
            datasets: [{
                label: 'Earnings',
                data: {!! json_encode($monthlyRevenue->pluck('revenue')) !!},
                borderColor: '#4338ca',
                borderWidth: 3,
                backgroundColor: 'rgba(67, 56, 202, 0.05)',
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#4338ca',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { borderDash: [5, 5], color: '#f1f5f9' },
                    ticks: { callback: value => '৳' + value }
                },
                x: { grid: { display: false } }
            }
        }
    });
</script>
</body>
</html>