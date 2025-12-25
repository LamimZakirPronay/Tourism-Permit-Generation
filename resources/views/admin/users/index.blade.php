@extends('layouts.admin_master')

@section('title', 'Personnel Management')

@section('content')
<div class="container py-2">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">Admin</a></li>
                            <li class="breadcrumb-item active fw-semibold" aria-current="page">Users</li>
                        </ol>
                    </nav>
                    <h2 class="fw-bold mb-0 text-dark">User Management</h2>
                    <p class="text-muted small mb-0">Monitor and manage access for system administrators and staff.</p>
                </div>
                
                <a href="{{ route('admin.users.create') }}" class="btn btn-add shadow-sm">
                    <i class="bi bi-person-plus-fill me-1"></i> Register New Officer
                </a>
            </div>

            {{-- Alert Messages --}}
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
                                    <th class="ps-4">Officer Detail</th>
                                    <th>Corps & Unit</th>
                                    <th>System Role</th>
                                    <th>Security</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-3">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $user->rank }} {{ $user->name }}</div>
                                                    <div class="text-muted small" style="font-size: 0.8rem;">BA-{{ $user->ba_no }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold small text-dark">{{ $user->corps }}</div>
                                            <div class="text-muted small" style="font-size: 0.75rem;">{{ $user->unit ?? 'General HQ' }}</div>
                                        </td>
                                        <td>
                                            <span class="status-badge {{ $user->role == 'admin' ? 'bg-danger-subtle' : 'bg-info-subtle' }}">
                                                {{ strtoupper($user->role) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($user->google2fa_secret)
                                                <span class="text-success small fw-bold">
                                                    <i class="bi bi-shield-check me-1"></i> 2FA Active
                                                </span>
                                            @else
                                                <span class="text-muted small">
                                                    <i class="bi bi-shield-slash me-1"></i> 2FA Off
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary rounded-3">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                
                                                @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Revoke access for this officer?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3">
                                                        <i class="bi bi-x-circle"></i> Revoke
                                                    </button>
                                                </form>
                                                @else
                                                    <div style="width: 75px;" class="text-center small text-muted italic">Self</div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="bi bi-person-x fs-2 d-block mb-2"></i>
                                            No users found. <a href="{{ route('admin.users.create') }}" class="text-primary fw-bold">Create the first officer account.</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if(method_exists($users, 'links'))
                <div class="mt-4 d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Specific styles for User Table matching your design */
    .table thead th {
        background-color: #f8fafc;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #64748b;
        border: none;
        padding: 1rem;
    }

    .avatar-circle {
        width: 38px;
        height: 38px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        border: 1px solid #dbeafe;
    }

    .status-badge {
        padding: 0.4em 0.7em;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .bg-danger-subtle { background-color: #fef2f2 !important; color: #dc2626 !important; }
    .bg-info-subtle { background-color: #f0f9ff !important; color: #0284c7 !important; }
    
    .btn-outline-primary { border-color: #dbeafe; color: #2563eb; }
    .btn-outline-primary:hover { background-color: #2563eb; color: white; border-color: #2563eb; }
    
    .btn-outline-danger { border-color: #fee2e2; color: #dc2626; }
    .btn-outline-danger:hover { background-color: #dc2626; color: white; border-color: #dc2626; }
</style>
@endsection