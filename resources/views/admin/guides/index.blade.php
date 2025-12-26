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
                
                <a href="{{ route('admin.guides.create') }}" class="btn btn-warning shadow-sm fw-bold">
                    <i class="bi bi-plus-lg me-1"></i> Add New Guide
                </a>
            </div>

            {{-- Success Alert --}}
            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2"></i> 
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            {{-- Error Alert (Crucial for debugging delete issues) --}}
            @if (session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> 
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <div class="card main-card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Guide Info</th>
                                    <th>Identity & Contact</th>
                                    <th>Personal Details</th>
                                    <th>Document</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($guides as $guide)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-3">
                                                    {{ strtoupper(substr($guide->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $guide->name }}</div>
                                                    <div class="text-muted small">License: <span class="fw-medium text-primary">{{ $guide->license_id }}</span></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="small text-dark fw-medium"><i class="bi bi-telephone me-1 text-muted"></i> {{ $guide->contact }}</div>
                                            <div class="small text-muted"><i class="bi bi-envelope me-1"></i> {{ $guide->email ?? 'No Email' }}</div>
                                        </td>
                                        <td>
                                            <div class="small text-dark">NID: {{ $guide->nid_number }}</div>
                                            <div class="small text-muted">Blood: <span class="text-danger fw-bold">{{ $guide->blood_group ?? 'N/A' }}</span></div>
                                        </td>
                                        <td>
                                            @if($guide->attachment_path)
                                                <a href="{{ asset('storage/' . $guide->attachment_path) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                    <i class="bi bi-file-earmark-pdf"></i> View
                                                </a>
                                            @else
                                                <span class="text-muted small italic">No File</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($guide->is_active)
                                                <span class="status-badge bg-success-subtle text-success">● Active</span>
                                            @else
                                                <span class="status-badge bg-danger-subtle text-danger">● Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end align-items-center gap-2">
                                                {{-- Edit Action --}}
                                                <a href="{{ route('admin.guides.edit', $guide->id) }}" 
                                                   class="btn-icon btn-light-warning" title="Edit Guide">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                {{-- Delete Action (Fixed Form Placement) --}}
                                                <form action="{{ route('admin.guides.destroy', $guide->id) }}" method="POST" class="d-inline">
                                                    @csrf 
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-icon btn-light-danger" 
                                                            title="Delete Guide" 
                                                            onclick="return confirm('Are you sure you want to delete this guide?')">
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
    .main-card { background: white; border-radius: 1rem; }
    .table thead th { 
        background-color: #f8fafc; 
        font-weight: 700; 
        text-transform: uppercase; 
        font-size: 0.75rem; 
        color: #475569; 
        padding: 1.25rem 0.5rem; 
        border-bottom: 1px solid #e2e8f0;
    }
    
    .avatar-circle {
        width: 40px;
        height: 40px;
        background-color: #fef3c7;
        color: #d97706;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: 800;
        font-size: 1rem;
    }

    .btn-icon { 
        width: 36px; 
        height: 36px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        border-radius: 10px; 
        border: none; 
        transition: all 0.2s; 
    }
    
    .btn-light-warning { background: #fffbeb; color: #d97706; }
    .btn-light-warning:hover { background: #fef3c7; transform: translateY(-2px); }
    
    .btn-light-danger { background: #fef2f2; color: #dc2626; }
    .btn-light-danger:hover { background: #fee2e2; transform: translateY(-2px); }

    .status-badge { 
        padding: 0.5em 0.8em; 
        border-radius: 20px; 
        font-weight: 700; 
        font-size: 0.7rem; 
    }
</style>
@endsection