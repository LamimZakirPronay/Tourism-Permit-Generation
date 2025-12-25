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
                    <h2 class="fw-bold mb-0 text-dark">Permit Operations</h2>
                    <p class="text-muted small mb-0">Manage arrivals, departures, and cancellations in real-time.</p>
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
            <div class="col-md-3">
                <label class="form-label small fw-bold text-uppercase text-muted">Search</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-light shadow-sm"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-light shadow-sm" placeholder="ID or Leader Name..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label small fw-bold text-uppercase text-muted">Arrival Date</label>
                <input type="date" name="arrival_date" class="form-control border-light shadow-sm" value="{{ request('arrival_date') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label small fw-bold text-uppercase text-muted">Departure Date</label>
                <input type="date" name="departure_date" class="form-control border-light shadow-sm" value="{{ request('departure_date') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label small fw-bold text-uppercase text-muted">Status</label>
                <select name="status" class="form-select border-light shadow-sm">
                    <option value="">All Statuses</option>
                    <option value="to arrive" {{ request('status') == 'to arrive' ? 'selected' : '' }}>To Arrive</option>
                    <option value="arrived" {{ request('status') == 'arrived' ? 'selected' : '' }}>Arrived</option>
                    <option value="exited" {{ request('status') == 'exited' ? 'selected' : '' }}>Exited</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-add w-100 shadow-sm">Apply</button>
                <a href="{{ route('admin.permit.index') }}" class="btn btn-dashboard shadow-sm text-center">Reset</a>
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

            @if (session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> 
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <div class="card main-card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Group / ID</th>
                                    <th>Leader & Contact</th>
                                    <th>Schedule</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Quick Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($permits as $item)
                                    @php 
                                        $isOverdue = $item->status == 'arrived' && \Carbon\Carbon::parse($item->departure_datetime)->isPast();
                                    @endphp
                                    <tr style="{{ $isOverdue ? 'background-color: #fff1f2;' : '' }}">
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $item->group_name }}</div>
                                            <div class="text-muted small">#{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }} | {{ $item->area_name }}</div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $item->leader_name }}</div>
                                            <div class="small text-muted">{{ $item->contact_number }}</div>
                                        </td>
                                        <td>
                                            <div class="small"><span class="text-muted">In:</span> {{ \Carbon\Carbon::parse($item->arrival_datetime)->format('M d, H:i') }}</div>
                                            <div class="small"><span class="text-muted">Out:</span> {{ \Carbon\Carbon::parse($item->departure_datetime)->format('M d, H:i') }}</div>
                                        </td>
                                        <td>
                                            @if($item->payment_status == 1)
                                                <span class="badge bg-success-subtle text-success border-0">Paid</span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger border-0">Unpaid</span>
                                            @endif
                                        </td>
                                        <td>
                                            @switch($item->status)
                                                @case('to arrive')
                                                    <span class="status-badge bg-info-subtle text-info">● To Arrive</span>
                                                    @break
                                                @case('arrived')
                                                    <span class="status-badge bg-primary-subtle text-primary">● Inside</span>
                                                    @break
                                                @case('exited')
                                                    <span class="status-badge bg-success-subtle text-success">● Exited</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="status-badge bg-secondary-subtle text-muted">● Cancelled</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end align-items-center gap-1">
                                                <a href="{{ route('admin.permit.show', $item->id) }}" class="btn-icon btn-light-primary" title="View"><i class="bi bi-eye"></i></a>
                                                <a href="{{ route('admin.permit.edit', $item->id) }}" class="btn-icon btn-light-warning" title="Edit"><i class="bi bi-pencil"></i></a>

                                                <div class="dropdown">
                                                    <button class="btn-icon btn-light-dark border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                                        <li><h6 class="dropdown-header">Update Status</h6></li>
                                                        
                                                        @if($item->status == 'to arrive')
                                                        <li>
                                                            <form action="{{ route('admin.permit.update-status', $item->id) }}" method="POST">
                                                                @csrf @method('PATCH')
                                                                <input type="hidden" name="status" value="arrived">
                                                                <button type="submit" class="dropdown-item text-primary" onclick="return confirm('Confirm Arrival?')">
                                                                    <i class="bi bi-geo-alt-fill me-2"></i> Mark Arrived
                                                                </button>
                                                            </form>
                                                        </li>
                                                        @endif

                                                        @if($item->status == 'arrived')
                                                        <li>
                                                            <form action="{{ route('admin.permit.update-status', $item->id) }}" method="POST">
                                                                @csrf @method('PATCH')
                                                                <input type="hidden" name="status" value="exited">
                                                                <button type="submit" class="dropdown-item text-success" onclick="return confirm('Confirm Exit?')">
                                                                    <i class="bi bi-box-arrow-right me-2"></i> Mark Exited
                                                                </button>
                                                            </form>
                                                        </li>
                                                        @endif

                                                        @if($item->status != 'exited' && $item->status != 'cancelled')
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form action="{{ route('admin.permit.update-status', $item->id) }}" method="POST">
                                                                @csrf @method('PATCH')
                                                                <input type="hidden" name="status" value="cancelled">
                                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to cancel this permit?')">
                                                                    <i class="bi bi-x-circle me-2"></i> Cancel Permit
                                                                </button>
                                                            </form>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">No records found matching criteria.</td>
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
    
    .btn-icon { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 6px; border: none; text-decoration: none; transition: 0.2s; }
    .btn-light-primary { background: #e0e7ff; color: #4338ca; }
    .btn-light-warning { background: #fef3c7; color: #b45309; }
    .btn-light-dark { background: #f1f5f9; color: #1e293b; }
    
    .status-badge { padding: 0.4em 0.7em; border-radius: 6px; font-weight: 700; font-size: 0.75rem; }
    .dropdown-item { font-size: 0.85rem; font-weight: 500; padding: 0.6rem 1.2rem; }
    .btn-dashboard { background: #f1f5f9; color: #475569; font-weight: 600; border-radius: 8px; padding: 0.5rem 1rem; border: none; }
    .btn-add { background: #1e293b; color: white; font-weight: 600; border-radius: 8px; padding: 0.5rem 1.25rem; border: none; }
</style>
@endsection