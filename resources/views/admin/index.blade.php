@extends('layouts.admin_master')

@section('title', 'User Management')

@section('content')
<div class="container py-2">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item active fw-semibold" aria-current="page">User Management</li>
                        </ol>
                    </nav>
                    <h2 class="fw-bold mb-0 text-dark">System Users</h2>
                    <p class="text-muted small mb-0">Manage administrative access and user accounts.</p>
                </div>
                
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.settings.edit') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-gear-fill me-1"></i> Site Settings
                    </a>
                    
                    <a href="{{ route('admin.users.create') }}" class="btn btn-add">
                        <i class="bi bi-person-plus-fill me-1"></i> Add New User
                    </a>
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
                                    <th class="ps-4">User Details</th>
                                    <th>Email Address</th>
                                    <th>Role / Status</th>
                                    <th>Joined Date</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px; font-size: 0.85rem;">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                                                    <div class="text-muted small">ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-dark">{{ $user->email }}</div>
                                        </td>
                                        <td>
                                            @if($user->is_admin)
                                                <span class="status-badge bg-primary-subtle text-primary">● Administrator</span>
                                            @else
                                                <span class="status-badge bg-light text-muted border">● Staff User</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="small fw-bold text-dark">{{ $user->created_at->format('M d, Y') }}</div>
                                            <div class="small text-muted">{{ $user->created_at->format('h:i A') }}</div>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end align-items-center gap-2">
                                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                                   class="btn-icon btn-light-warning" title="Edit User">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                
                                                @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf 
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-icon btn-light-danger" title="Delete User" onclick="return confirm('Are you sure you want to delete this user?')">
                                                        <i class="bi bi-trash3-fill"></i>
                                                    </button>
                                                </form>
                                                @else
                                                    <div style="width: 34px;" title="Current Session"></div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="bi bi-people mb-2 d-block fs-2"></i>
                                            No users found in the system.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling to match Permit management exactly */
    .table thead th { 
        background-color: #f1f5f9; 
        font-weight: 700; 
        text-transform: uppercase; 
        font-size: 0.7rem; 
        color: #64748b; 
        padding: 1.25rem 0.5rem; 
        border: none; 
    }
    
    .btn-add {
        background-color: #198754;
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        transition: 0.3s;
    }
    
    .btn-add:hover {
        background-color: #146c43;
        color: white;
    }

    .btn-icon { 
        width: 34px; 
        height: 34px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        border-radius: 8px; 
        border: none; 
        text-decoration: none; 
        transition: 0.2s; 
    }
    
    .btn-light-warning { background: #fef3c7; color: #b45309; }
    .btn-light-warning:hover { background: #b45309; color: white; }
    
    .btn-light-danger { background: #fee2e2; color: #b91c1c; }
    .btn-light-danger:hover { background: #b91c1c; color: white; }

    .status-badge { padding: 0.4em 0.7em; border-radius: 6px; font-weight: 700; font-size: 0.75rem; }
</style>
@endsection