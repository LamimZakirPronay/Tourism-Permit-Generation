@extends('layouts.admin_master')

@section('title', 'Add Tour Guide')

@section('content')
<div class="container py-2 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.guides.index') }}" class="text-decoration-none text-muted">Tour Guides</a></li>
                        <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">New Registration</li>
                    </ol>
                </nav>
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="fw-bold mb-0 text-dark">👤 Add New Tour Guide</h2>
                    <a href="{{ route('admin.guides.index') }}" class="btn btn-outline-secondary btn-sm rounded-3">
                        <i class="bi bi-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>

            <form action="{{ route('admin.guides.store') }}" method="POST" enctype="multipart/form-data" class="form-card p-4 p-md-5">
                @csrf

                <div class="section-title">Personal Information</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter full name" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Parent's Name</label>
                        <input type="text" name="parent_name" class="form-control" value="{{ old('parent_name') }}" placeholder="Father/Mother name">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Blood Group</label>
                        <select name="blood_group" class="form-select">
                            <option value="">Select Group</option>
                            @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $group)
                                <option value="{{ $group }}" {{ old('blood_group') == $group ? 'selected' : '' }}>{{ $group }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Marital Status</label>
                        <select name="marital_status" class="form-select">
                            <option value="Single" {{ old('marital_status') == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('marital_status') == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Other" {{ old('marital_status') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Spouse Name (If applicable)</label>
                        <input type="text" name="spouse_name" class="form-control" value="{{ old('spouse_name') }}" placeholder="Enter spouse name">
                    </div>
                </div>

                <div class="section-title">Contact & Identity</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="example@mail.com">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Primary Contact</label>
                        <input type="text" name="contact" class="form-control @error('contact') is-invalid @enderror" value="{{ old('contact') }}" placeholder="Phone number" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Emergency Contact</label>
                        <input type="text" name="emergency_contact" class="form-control" value="{{ old('emergency_contact') }}" placeholder="Name / Phone">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">License ID (Unique)</label>
                        <input type="text" name="license_id" class="form-control @error('license_id') is-invalid @enderror" value="{{ old('license_id') }}" placeholder="TG-XXXXX" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NID Card Number</label>
                        <input type="text" name="nid_number" class="form-control @error('nid_number') is-invalid @enderror" value="{{ old('nid_number') }}" placeholder="NID Number" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Permanent Address</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="Enter full address">{{ old('address') }}</textarea>
                    </div>
                </div>

                <div class="section-title">Documents & Status</div>
                <div class="row g-3 mb-5">
                    <div class="col-md-8">
                        <label class="form-label">Upload NID / Necessary Files (PDF, JPG, PNG)</label>
                        <input type="file" name="attachment" class="form-control @error('attachment') is-invalid @enderror">
                        <div class="form-text text-muted">Maximum file size allowed is 2MB.</div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_active">Active Account</label>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-top d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm" style="border-radius: 10px;">
                        <i class="bi bi-person-check-fill me-2"></i> Save Tour Guide Profile
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
        color: #0d6efd; 
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
        border-color: #0d6efd; 
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1); 
    }
</style>
@endsection