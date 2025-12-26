@extends('layouts.admin_master')

@if(session('autodownload'))
    <script>
        window.onload = function() {
            const link = document.createElement('a');
            link.href = "{{ session('autodownload') }}";
            link.setAttribute('download', 'GroupPermit.pdf');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        };
    </script>
@endif

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            {{-- Header Section --}}
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
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
                
                <div class="d-flex gap-2 mt-3 mt-sm-0">
                    <a href="{{ route('admin.permit.index') }}" class="btn btn-dashboard">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </a>
                </div>
            </div>

            {{-- Filters --}}
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

            {{-- Table --}}
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
                                    <th class="text-center pe-4">Actions</th>
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
                                            <div class="text-muted small mb-1">#{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</div>
                                            {{-- Displaying Multiple Areas --}}
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($item->areas as $area)
                                                    <span class="badge bg-light text-dark border-0 small py-1 px-2" style="font-size: 0.65rem;">{{ $area->name }}</span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $item->leader_name }}</div>
                                            <div class="small text-muted">{{ $item->contact_number }}</div>
                                        </td>
                                        <td>
                                            <div class="small"><span class="text-muted small">In:</span> {{ \Carbon\Carbon::parse($item->arrival_datetime)->format('M d, H:i') }}</div>
                                            <div class="small"><span class="text-muted small">Out:</span> {{ \Carbon\Carbon::parse($item->departure_datetime)->format('M d, H:i') }}</div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $item->payment_status == 1 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} border-0">
                                                {{ $item->payment_status == 1 ? 'Paid' : 'Unpaid' }}
                                            </span>
                                        </td>
                                        <td>
                                            @switch($item->status)
                                                @case('to arrive')
                                                    <span class="status-badge bg-info-subtle text-info">● To Arrive</span> @break
                                                @case('arrived')
                                                    <span class="status-badge bg-primary-subtle text-primary">● Inside</span> @break
                                                @case('exited')
                                                    <span class="status-badge bg-success-subtle text-success">● Exited</span> @break
                                                @case('cancelled')
                                                    <span class="status-badge bg-secondary-subtle text-muted">● Cancelled</span> @break
                                            @endswitch
                                        </td>
                                        <td class="pe-4">
                                            {{-- EXPANDED ACTIONS --}}
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <a href="{{ route('admin.permit.show', $item->id) }}" class="btn-action btn-view" title="View Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                
                                                <a href="{{ route('admin.permit.edit', $item->id) }}" class="btn-action btn-edit" title="Edit Record">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                {{-- Status Shortcut Buttons --}}
                                                @if($item->status == 'to arrive')
                                                    <form action="{{ route('admin.permit.update-status', $item->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="arrived">
                                                        <button type="submit" class="btn-action btn-arrive" title="Mark Arrived" onclick="return confirm('Confirm Group Arrival?')">
                                                            <i class="bi bi-geo-alt-fill"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($item->status == 'arrived')
                                                    <form action="{{ route('admin.permit.update-status', $item->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="exited">
                                                        <button type="submit" class="btn-action btn-exit" title="Mark Exited" onclick="return confirm('Confirm Group Exit?')">
                                                            <i class="bi bi-box-arrow-right"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($item->status != 'exited' && $item->status != 'cancelled')
                                                    <form action="{{ route('admin.permit.update-status', $item->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <button type="submit" class="btn-action btn-cancel" title="Cancel Permit" onclick="return confirm('Cancel this permit?')">
                                                            <i class="bi bi-x-circle"></i>
                                                        </button>
                                                    </form>
                                                @endif
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
    
    /* Expanded Action Button Styles */
    .btn-action { width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border-radius: 8px; border: none; text-decoration: none; transition: all 0.2s; font-size: 1rem; }
    
    .btn-view { background: #e0f2fe; color: #0369a1; }
    .btn-view:hover { background: #0369a1; color: white; }
    
    .btn-edit { background: #fef3c7; color: #b45309; }
    .btn-edit:hover { background: #b45309; color: white; }
    
    .btn-arrive { background: #dcfce7; color: #15803d; }
    .btn-arrive:hover { background: #15803d; color: white; }
    
    .btn-exit { background: #ede9fe; color: #6d28d9; }
    .btn-exit:hover { background: #6d28d9; color: white; }
    
    .btn-cancel { background: #fee2e2; color: #b91c1c; }
    .btn-cancel:hover { background: #b91c1c; color: white; }
    
    .status-badge { padding: 0.4em 0.7em; border-radius: 6px; font-weight: 700; font-size: 0.75rem; white-space: nowrap; }
    .btn-dashboard { background: #f1f5f9; color: #475569; font-weight: 600; border-radius: 8px; padding: 0.5rem 1rem; border: none; }
    .btn-add { background: #1e293b; color: white; font-weight: 600; border-radius: 8px; padding: 0.5rem 1.25rem; border: none; }
</style>
@endsection