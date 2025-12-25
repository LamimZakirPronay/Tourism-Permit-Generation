@extends('layouts.admin_master')
@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">System Configuration</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Content Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Site Name</label>
                            <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}" placeholder="e.g. Forest Department Tourism">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Permit Instructions (PDF Footer)</label>
                            <textarea name="instructions" class="form-control" rows="8" placeholder="Enter terms and conditions for the permit...">{{ $settings['permit_instructions'] ?? '' }}</textarea>
                            <div class="form-text">This text will appear at the bottom of every generated PDF permit.</div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold">Emergency Contacts</label>
                            <textarea name="contacts" class="form-control" rows="2" placeholder="e.g. Help Desk: 017xx-xxxxxx, Police: 999">{{ $settings['emergency_contacts'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Branding</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <label class="form-label fw-bold d-block text-start">Current Logo</label>
                            <div class="p-3 border rounded bg-light d-flex align-items-center justify-content-center" style="height: 120px;">
                                @if(isset($settings['site_logo']))
                                    <img src="{{ $settings['site_logo'] }}" alt="Logo" style="max-height: 100%; max-width: 100%;">
                                @else
                                    <span class="text-muted">No Logo Uploaded</span>
                                @endif
                            </div>
                        </div>
                        <input type="file" name="site_logo" class="form-control shadow-sm">
                        <small class="text-muted mt-2 d-block">Recommended: Transparent PNG (max 2MB)</small>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Permit Pricing</h6>
                    </div>
                    <div class="card-body">
                        <label class="form-label fw-bold">Base Fee (per person/group)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">৳</span>
                            <input type="number" name="permit_fee" class="form-control" value="{{ $settings['permit_fee'] ?? '500' }}">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm py-3 fw-bold">
                    <i class="bi bi-cloud-arrow-up-fill me-2"></i> Update Settings
                </button>
            </div>
        </div>
    </form>
</div>
@endsection