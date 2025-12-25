@extends('layouts.admin_master')

@section('title', 'Manage Guides')

@section('content')
<div class="container py-2">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item active fw-semibold" aria-current="page">Tour Guides</li>
                        </ol>
                    </nav>
                    <h2 class="fw-bold mb-0 text-dark">Tour Guide Management</h2>
                    <p class="text-muted small mb-0">Manage and oversee all registered tour guides.</p>
                </div>
                
                <a href="{{ route('admin.guides.create') }}" class="btn btn-add shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Add New Guide
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
                                    <th class="ps-4">ID</th>
                                    <th>Name</th>
                                    <th>License ID</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($guides as $guide)
                                    <tr>
                                        <td class="ps-4 fw-bold text-muted">#{{ $guide->id }}</td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $guide->name }}</div>
                                        </td>
                                        <td><code class="text-primary fw-medium">{{ $guide->license_id }}</code></td>
                                        <td>
                                            <div class="small text-dark"><i class="bi bi-telephone me-1 text-muted"></i> {{ $guide->contact }}</div>
                                        </td>
                                        <td>
                                            @if($guide->is_active)
                                                <span class="status-badge bg-success-subtle text-success">
                                                    ● Active
                                                </span>
                                            @else
                                                <span class="status-badge bg-danger-subtle text-danger">
                                                    ● Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end align-items-center gap-2">
                                                <a href="{{ route('admin.guides.edit', $guide->id) }}" 
                                                   class="btn-icon btn-light-warning" title="Edit Guide">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <form action="{{ route('admin.guides.destroy', $guide->id) }}" method="POST" class="d-inline">
                                                    @csrf 
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-icon btn-light-danger" title="Delete Guide" onclick="return confirm('Are you sure you want to delete this guide?')">
                                                        <i class="bi bi-trash3-fill"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="bi bi-person-badge fs-2 d-block mb-2"></i>
                                            No tour guides found. <a href="{{ route('admin.guides.create') }}" class="text-primary fw-bold">Create the first one.</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if(method_exists($guides, 'links'))
                <div class="mt-4 d-flex justify-content-center">
                    {{ $guides->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Styling to match Permit and User management tables */
    .table thead th { 
        background-color: #f1f5f9; 
        font-weight: 700; 
        text-transform: uppercase; 
        font-size: 0.7rem; 
        color: #64748b; 
        padding: 1.25rem 0.5rem; 
        border: none; 
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

    .status-badge { 
        padding: 0.4em 0.7em; 
        border-radius: 6px; 
        font-weight: 700; 
        font-size: 0.75rem; 
    }
</style>
@endsection