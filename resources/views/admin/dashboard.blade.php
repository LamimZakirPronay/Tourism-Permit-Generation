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
        .stat-card { border: none; border-radius: 12px; transition: transform 0.2s; position: relative; overflow: hidden; height: 100%; }
        .stat-card:hover { transform: translateY(-5px); }
        .revenue-gradient { background: linear-gradient(135deg, #0f172a 0%, #334155 100%); color: white; }
        .today-gradient { background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; }
        .icon-box { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 8px; }
        .chart-container { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .card-title-sm { font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: #64748b; margin-bottom: 0.5rem; }
        .text-white-opacity { color: rgba(255,255,255,0.8); }
        
        .bg-info-subtle { background-color: #e0f2fe !important; }
        .bg-primary-subtle { background-color: #eef2ff !important; }
        .bg-success-subtle { background-color: #f0fdf4 !important; }
        .bg-warning-subtle { background-color: #fffbeb !important; }
        .bg-danger-subtle { background-color: #fef2f2 !important; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark mb-4 shadow-sm">
    <div class="container">
        <span class="navbar-brand fw-bold"><i class="bi bi-compass me-2 text-primary"></i>Tourism Admin Panel</span>
        <div class="d-flex align-items-center">
            <span class="text-white-50 me-3 small d-none d-md-inline">Welcome, {{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-light btn-sm rounded-pill px-3">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container pb-5">
    
    {{-- Section 1: Today's Insights --}}
    <h5 class="fw-bold mb-3"><i class="bi bi-calendar-event me-2 text-success"></i>Today's Snapshot</h5>
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card stat-card today-gradient shadow-sm p-4">
                <div class="card-title-sm text-white-opacity">Revenue Today</div>
                <h2 class="fw-bold mb-0">৳{{ number_format($todayRevenue, 2) }}</h2>
                <div class="mt-2 small text-white-opacity"><i class="bi bi-graph-up-arrow me-1"></i> Daily Collection</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card bg-white shadow-sm p-4 border-start border-primary border-4">
                <div class="card-title-sm">Groups Expected</div>
                <h2 class="fw-bold mb-0 text-dark">{{ $permitStats['expected_today'] }}</h2>
                <div class="mt-2 small text-muted"><i class="bi bi-clock me-1"></i> Arriving on {{ date('M d') }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card bg-white shadow-sm p-4 border-start border-info border-4">
                <div class="card-title-sm">Individual Headcount</div>
                <h2 class="fw-bold mb-0 text-dark">{{ number_format($visitorsExpectedToday) }}</h2>
                <div class="mt-2 small text-muted"><i class="bi bi-people me-1"></i> Total persons expected</div>
            </div>
        </div>
    </div>

    {{-- Section 2: Lifetime Statistics --}}
    <h5 class="fw-bold mb-3"><i class="bi bi-database me-2 text-primary"></i>Overall Statistics</h5>
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card revenue-gradient shadow-sm p-3">
                <div class="card-title-sm text-white-opacity">Total Revenue</div>
                <h2 class="fw-bold mb-0">৳{{ number_format($totalRevenue, 2) }}</h2>
                <div class="mt-2 small text-white-opacity"><i class="bi bi-wallet2 me-1"></i> Lifetime Earnings</div>
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
                <div class="card-title-sm text-warning">People Inside</div>
                <h2 class="fw-bold mb-0 text-dark">{{ $permitStats['inside'] }}</h2>
                <div class="mt-2 small text-muted"><i class="bi bi-geo-alt-fill me-1"></i> Current Headcount</div>
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
                    <h5 class="fw-bold mb-0 text-dark">Revenue Trend</h5>
                    <span class="badge bg-light text-dark border px-3 py-2">Last 6 Months</span>
                </div>
                <div style="height: 350px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Resource Management Sidebar --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h5 class="fw-bold mb-4 text-dark">Quick Actions</h5>
                
                {{-- User Control --}}
                <div class="d-flex align-items-center p-3 mb-3 rounded-3 border bg-light-subtle">
                    <div class="icon-box bg-primary-subtle text-primary me-3"><i class="bi bi-people-fill"></i></div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold small">User Control</h6>
                        <small class="text-muted">{{ $counts['users'] }} Accounts</small>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary rounded-pill">View</a>
                </div>

                {{-- Tour Guides --}}
                <div class="d-flex align-items-center p-3 mb-3 rounded-3 border bg-light-subtle">
                    <div class="icon-box bg-success-subtle text-success me-3"><i class="bi bi-person-badge-fill"></i></div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold small">Tour Guides</h6>
                        <small class="text-muted">{{ $counts['guides'] }} Active</small>
                    </div>
                    <a href="{{ route('admin.guides.index') }}" class="btn btn-sm btn-success rounded-pill">View</a>
                </div>

                {{-- Driver Section --}}
                <div class="d-flex align-items-center p-3 mb-3 rounded-3 border bg-light-subtle">
                    <div class="icon-box bg-warning-subtle text-warning me-3"><i class="bi bi-truck"></i></div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold small">Drivers</h6>
                        <small class="text-muted">{{ $counts['drivers'] }} Records</small>
                    </div>
                    <a href="{{ route('admin.drivers.index') }}" class="btn btn-sm btn-warning rounded-pill">View</a>
                </div>


{{-- Site Settings (RESTORED) --}}
<div class="d-flex align-items-center p-3 mb-3 rounded-3 border bg-light-subtle">
    <div class="icon-box bg-dark-subtle text-dark me-3"><i class="bi bi-gear-fill"></i></div>
    <div class="flex-grow-1">
        <h6 class="mb-0 fw-bold small">Site Settings</h6>
        <small class="text-muted">Configuration</small>
    </div>
    <a href="{{ route('admin.settings.edit') }}" class="btn btn-sm btn-dark rounded-pill">Edit</a>
</div>
                <div class="mt-auto">
                    <a href="{{ route('admin.permit.index') }}" class="btn btn-dark w-100 py-3 fw-bold rounded-3 shadow-sm">
                        <i class="bi bi-file-earmark-text me-2"></i>Review All Permits
                    </a>
                </div>
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