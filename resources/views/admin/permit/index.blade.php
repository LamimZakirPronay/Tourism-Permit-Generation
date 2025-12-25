@extends('layouts.admin_master')

@section('content')


<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item active fw-semibold" aria-current="page">Permit Management</li>
                        </ol>
                    </nav>
                    <h2 class="fw-bold mb-0 text-dark">Issued Permits</h2>
                    <p class="text-muted small mb-0">Monitor active permits and manage tourist departures.</p>
                </div>
                
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.permit.index') }}" class="btn btn-dashboard">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </a>
                </div>
            </div>

            <div class="card main-card mb-4 border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.permit.index') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-uppercase text-muted">Departure Date</label>
                            <input type="date" name="departure_date" class="form-control border-light shadow-sm" value="{{ request('departure_date') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-uppercase text-muted">Status</label>
                            <select name="status" class="form-select border-light shadow-sm">
                                <option value="">All Statuses</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active (Inside)</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Exited (Completed)</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-add w-100 shadow-sm">Apply Filters</button>
                            <a href="{{ route('admin.permit.index') }}" class="btn btn-dashboard shadow-sm">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2"></i> 
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            <div class="card main-card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Group Info</th>
                                    <th>Leader</th>
                                    <th>Area</th>
                                    <th>Departure</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($permits as $item)
                                    @php 
                                        $isOverdue = $item->status == 'active' && \Carbon\Carbon::parse($item->departure_datetime)->isPast();
                                    @endphp
                                    <tr style="{{ $isOverdue ? 'background-color: #fff1f2;' : '' }}">
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $item->group_name }}</div>
                                            <div class="text-muted small">#{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $item->leader_name }}</div>
                                            <div class="small text-muted">{{ $item->contact_number }}</div>
                                        </td>
                                        <td><span class="text-primary fw-medium">{{ $item->area_name }}</span></td>
                                        <td>
                                            <div class="small fw-bold">{{ \Carbon\Carbon::parse($item->departure_datetime)->format('M d, Y') }}</div>
                                            <div class="small text-muted">{{ \Carbon\Carbon::parse($item->departure_datetime)->format('h:i A') }}</div>
                                        </td>
                                        <td>
                                            @if($item->status == 'active')
                                                <span class="status-badge bg-primary-subtle text-primary">● Active</span>
                                            @else
                                                <span class="status-badge bg-success-subtle text-success">● Exited</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end align-items-center gap-2">
                                                <a href="{{ route('admin.permit.show', $item->id) }}" 
                                                   class="btn-icon btn-light-primary" title="View">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>

                                                <a href="{{ route('admin.permit.edit', $item->id) }}" 
                                                   class="btn-icon btn-light-warning" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                @if($item->status == 'active')
                                                <form action="{{ route('admin.permit.exit', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="btn-icon btn-light-success" title="Exit" onclick="return confirm('Confirm exit?')">
                                                        <i class="bi bi-box-arrow-right"></i>
                                                    </button>
                                                </form>
                                                @else
                                                    <div style="width: 34px;"></div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">No records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 d-flex justify-content-center">
                {{ $permits->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
    .main-card { background: #ffffff; border-radius: 1rem; overflow: hidden; }
    .table thead th { background-color: #f1f5f9; font-weight: 700; text-transform: uppercase; font-size: 0.7rem; color: #64748b; padding: 1.25rem 0.5rem; border: none; }
    
    /* Icon Button Style */
    .btn-icon { width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border-radius: 8px; border: none; text-decoration: none; transition: 0.2s; }
    
    .btn-light-primary { background: #e0e7ff; color: #4338ca; }
    .btn-light-primary:hover { background: #4338ca; color: white; }
    
    .btn-light-warning { background: #fef3c7; color: #b45309; }
    .btn-light-warning:hover { background: #b45309; color: white; }
    
    .btn-light-success { background: #dcfce7; color: #15803d; }
    .btn-light-success:hover { background: #15803d; color: white; }

    .status-badge { padding: 0.4em 0.7em; border-radius: 6px; font-weight: 700; font-size: 0.75rem; }
    .btn-dashboard { background: #f1f5f9; color: #475569; font-weight: 600; border-radius: 8px; padding: 0.5rem 1rem; border: none; }
    .btn-add { background: #1e293b; color: white; font-weight: 600; border-radius: 8px; padding: 0.5rem 1.25rem; border: none; }
</style>
@endsection