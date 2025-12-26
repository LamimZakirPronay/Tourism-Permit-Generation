@extends('layouts.admin_master')

@section('title', 'Edit Guide')

@section('content')
<div class="container py-2 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.guides.index') }}" class="text-decoration-none text-muted">Tour Guides</a></li>
                        <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">Edit Profile</li>
                    </ol>
                </nav>
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="fw-bold mb-0 text-dark">📝 Edit Guide: <span class="text-warning">{{ $guide->name }}</span></h2>
                    <a href="{{ route('admin.guides.index') }}" class="btn btn-outline-secondary btn-sm rounded-3">
                        <i class="bi bi-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger shadow-sm border-0 mb-4" style="border-radius: 12px;">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.guides.update', $guide->id) }}" method="POST" enctype="multipart/form-data" class="form-card p-4 p-md-5">
                @csrf
                @method('PUT')

                <div class="section-title">Personal Information</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $guide->name) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Parent's Name</label>
                        <input type="text" name="parent_name" class="form-control" value="{{ old('parent_name', $guide->parent_name) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Blood Group</label>
                        <select name="blood_group" class="form-select">
                            <option value="">Select Group</option>
                            @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $group)
                                <option value="{{ $group }}" {{ old('blood_group', $guide->blood_group) == $group ? 'selected' : '' }}>{{ $group }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Marital Status</label>
                        <select name="marital_status" class="form-select">
                            <option value="Single" {{ old('marital_status', $guide->marital_status) == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('marital_status', $guide->marital_status) == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Other" {{ old('marital_status', $guide->marital_status) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Spouse Name</label>
                        <input type="text" name="spouse_name" class="form-control" value="{{ old('spouse_name', $guide->spouse_name) }}">
                    </div>
                </div>

                <div class="section-title">Contact & Identity</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $guide->email) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Primary Contact</label>
                        <input type="text" name="contact" class="form-control @error('contact') is-invalid @enderror" value="{{ old('contact', $guide->contact) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Emergency Contact</label>
                        <input type="text" name="emergency_contact" class="form-control" value="{{ old('emergency_contact', $guide->emergency_contact) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">License ID (Unique)</label>
                        <input type="text" name="license_id" class="form-control @error('license_id') is-invalid @enderror" value="{{ old('license_id', $guide->license_id) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NID Card Number</label>
                        <input type="text" name="nid_number" class="form-control @error('nid_number') is-invalid @enderror" value="{{ old('nid_number', $guide->nid_number) }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Permanent Address</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address', $guide->address) }}</textarea>
                    </div>
                </div>

                <div class="section-title">Documents & Status</div>
                <div class="row g-3 mb-5">
                    <div class="col-md-8">
                        <label class="form-label">Replace NID / File (Leave blank to keep current)</label>
                        <input type="file" name="attachment" class="form-control mb-2 @error('attachment') is-invalid @enderror">
                        
                        @if($guide->attachment_path)
                            <div class="attachment-preview">
                                <span class="text-muted">Current file:</span> 
                                <a href="{{ asset('storage/' . $guide->attachment_path) }}" target="_blank" class="fw-bold text-decoration-none text-primary">
                                    <i class="bi bi-file-earmark-text me-1"></i> View Document
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $guide->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_active">Active Account</label>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-top d-flex justify-content-between align-items-center">
                    <p class="text-muted small mb-0">Last updated: {{ $guide->updated_at->format('M d, Y') }}</p>
                    <button type="submit" class="btn btn-warning px-5 py-2 fw-bold text-dark shadow-sm" style="border-radius: 10px;">
                        <i class="bi bi-cloud-arrow-up-fill me-1"></i> Update Guide Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-card { 
        background: white; 
        border: none; 
        border-radius: 1.25rem; 
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); 
    }
    .section-title { 
        font-size: 1.1rem; 
        font-weight: 700; 
        color: #f59e0b; 
        margin-bottom: 1.5rem; 
        display: flex; 
        align-items: center; 
    }
    .section-title::after { 
        content: ""; 
        height: 2px; 
        flex-grow: 1; 
        background: #e2e8f0; 
        margin-left: 15px; 
    }
    .form-label { font-weight: 600; font-size: 0.85rem; color: #475569; }
    .form-control, .form-select { 
        border-radius: 8px; 
        padding: 0.6rem 0.8rem; 
        border: 1.5px solid #e2e8f0; 
    }
    .form-control:focus, .form-select:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.1);
    }
    .attachment-preview { 
        background: #f8fafc; 
        padding: 10px; 
        border-radius: 8px; 
        font-size: 0.85rem; 
        border: 1px dashed #cbd5e1; 
    }
</style>
@endsection