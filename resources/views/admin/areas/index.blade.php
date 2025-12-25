@extends('layouts.admin_master') {{-- Or whatever your layout file is named --}}

@section('title', 'Manage Areas')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Restricted Areas</h2>
                <p class="text-muted">Manage locations available for permit selection</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn-dashboard text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
            </a>
        </div>

        {{-- Add New Area Card --}}
        <div class="main-card p-4 mb-4">
            <h5 class="fw-bold mb-3">Add New Area</h5>
            <form action="{{ route('admin.areas.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-9">
                        <input type="text" name="name" class="form-control form-control-lg border-0 bg-light" 
                               placeholder="e.g. Sundarbans East Zone" style="border-radius: 10px;" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn-add w-100 h-100 py-2">
                            <i class="bi bi-plus-lg me-1"></i> Save Area
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Areas List Table --}}
        <div class="main-card">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Area Name</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted">Status</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($areas as $area)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $area->name }}</td>
                            <td>
                                <span class="badge rounded-pill {{ $area->is_active ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }} px-3">
                                    {{ $area->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.areas.destroy', $area->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm border-0 rounded-circle" 
                                            onclick="return confirm('Remove this area?')">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">No areas added yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection