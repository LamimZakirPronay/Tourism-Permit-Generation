@extends('layouts.admin_master')

@section('title', 'Add New Tour Guide')

@section('content')
    <h1 class="mb-4 text-success">👤 Add New Tour Guide</h1>

    <form action="{{ route('admin.guides.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="license_id" class="form-label">License ID (Unique)</label>
            <input type="text" class="form-control @error('license_id') is-invalid @enderror" id="license_id" name="license_id" value="{{ old('license_id') }}" required>
            @error('license_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="contact" class="form-label">Contact Number</label>
            <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact" name="contact" value="{{ old('contact') }}" required>
            @error('contact') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4 form-check">
            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active (Appears in client selection form)</label>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.guides.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-success">Save Guide</button>
        </div>
    </form>
@endsection