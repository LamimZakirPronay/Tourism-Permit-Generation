@extends('layouts.admin_master')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Permit Management</h1>
    <a href="{{ route('admin.permit.index') }}" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm"></i> Back to Permit List
    </a>
</div>

{{-- Validation Error Display --}}
@if ($errors->any())
    <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
        <strong>Update Failed!</strong> Please check the following:
        <ul class="mt-2 mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<form action="{{ route('admin.permit.update', $permit->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Full Edit: Permit #{{ $permit->id }}</h6>
                    <span class="badge badge-{{ $permit->status == 'cancelled' ? 'danger' : 'success' }} p-2">
                        CURRENT STATUS: {{ strtoupper($permit->status) }}
                    </span>
                </div>
                <div class="card-body">

                    <div class="row mb-4">
                        <div class="col-12"><p class="text-primary font-weight-bold border-bottom pb-1">1. Logistics & Status</p></div>
                        
                        <div class="form-group col-md-4">
                            <label class="small font-weight-bold">Group Name</label>
                            <input type="text" name="group_name" class="form-control" value="{{ old('group_name', $permit->group_name) }}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="small font-weight-bold">Restricted Area</label>
                            <select name="area_id" class="form-control" required>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}" {{ (old('area_id', $permit->areas->first()->id ?? '') == $area->id) ? 'selected' : '' }}>
                                        {{ $area->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="small font-weight-bold">Tour Guide</label>
                            <select name="tour_guide_id" class="form-control" required>
                                @foreach($guides as $guide)
                                    <option value="{{ $guide->id }}" {{ (old('tour_guide_id', $permit->tour_guide_id) == $guide->id) ? 'selected' : '' }}>
                                        {{ $guide->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">Arrival Date/Time</label>
                            <input type="datetime-local" name="arrival_datetime" class="form-control" value="{{ old('arrival_datetime', \Carbon\Carbon::parse($permit->arrival_datetime)->format('Y-m-d\TH:i')) }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">Departure Date/Time</label>
                            <input type="datetime-local" name="departure_datetime" class="form-control" value="{{ old('departure_datetime', \Carbon\Carbon::parse($permit->departure_datetime)->format('Y-m-d\TH:i')) }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">Trip Status</label>
                            <select name="status" class="form-control border-primary font-weight-bold">
                                @foreach(['to arrive', 'arrived', 'exited', 'cancelled'] as $st)
                                    <option value="{{ $st }}" {{ old('status', $permit->status) == $st ? 'selected' : '' }}>{{ strtoupper($st) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">Payment Status</label>
                            <select name="payment_status" class="form-control">
                                <option value="1" {{ old('payment_status', $permit->payment_status) == 1 ? 'selected' : '' }}>Completed</option>
                                <option value="0" {{ old('payment_status', $permit->payment_status) == 0 ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12"><p class="text-primary font-weight-bold border-bottom pb-1">2. Leader Information</p></div>
                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">Leader Name</label>
                            <input type="text" name="leader_name" class="form-control" value="{{ old('leader_name', $permit->leader_name) }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">Leader NID</label>
                            <input type="text" name="leader_nid" class="form-control" value="{{ old('leader_nid', $permit->leader_nid) }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $permit->contact_number) }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $permit->email) }}">
                        </div>
                    </div>

                    <div class="row mb-4 bg-light p-3 border rounded">
                        <div class="col-12"><p class="text-primary font-weight-bold border-bottom pb-1">3. Driver & Vehicle Details</p></div>
                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">Driver Name</label>
                            <input type="text" name="driver_name" class="form-control" value="{{ old('driver_name', $permit->driver_name) }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">Driver Phone</label>
                            <input type="text" name="driver_contact" class="form-control" value="{{ old('driver_contact', $permit->driver_contact) }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">Driver Emergency Phone</label>
                            <input type="text" name="driver_emergency_contact" class="form-control" value="{{ old('driver_emergency_contact', $permit->driver_emergency_contact) }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">Driver NID</label>
                            <input type="text" name="driver_nid" class="form-control" value="{{ old('driver_nid', $permit->driver_nid) }}">
                        </div>
                        <div class="form-group col-md-3 mt-2">
                            <label class="small font-weight-bold">Driver License No</label>
                            <input type="text" name="driver_license_no" class="form-control" value="{{ old('driver_license_no', $permit->driver_license_no) }}">
                        </div>
                        <div class="form-group col-md-3 mt-2">
                            <label class="small font-weight-bold">Driver Blood Group</label>
                            <input type="text" name="driver_blood_group" class="form-control" value="{{ old('driver_blood_group', $permit->driver_blood_group) }}">
                        </div>
                        <div class="form-group col-md-3 mt-2">
                            <label class="small font-weight-bold">Vehicle Ownership</label>
                            <input type="text" name="vehicle_ownership" class="form-control" value="{{ old('vehicle_ownership', $permit->vehicle_ownership) }}">
                        </div>
                        <div class="form-group col-md-3 mt-2">
                            <label class="small font-weight-bold">Vehicle Reg No</label>
                            <input type="text" name="vehicle_reg_no" class="form-control" value="{{ old('vehicle_reg_no', $permit->vehicle_reg_no) }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12"><p class="text-primary font-weight-bold border-bottom pb-1">4. Team Members List</p></div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead class="bg-gray-100 small font-weight-bold">
                                        <tr>
                                            <th>Name</th>
                                            <th>Father's Name</th>
                                            <th style="width:70px;">Age</th>
                                            <th style="width:110px;">Gender</th>
                                            <th style="width:120px;">Category</th>
                                            <th>ID/NID</th>
                                            <th>Profession</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permit->teamMembers as $index => $member)
                                        <tr>
                                            <td>
                                                <input type="hidden" name="team[{{ $index }}][id]" value="{{ $member->id }}">
                                                <input type="text" name="team[{{ $index }}][name]" class="form-control form-control-sm" value="{{ old('team.'.$index.'.name', $member->name) }}">
                                            </td>
                                            <td><input type="text" name="team[{{ $index }}][fathers_name]" class="form-control form-control-sm" value="{{ old('team.'.$index.'.fathers_name', $member->fathers_name) }}"></td>
                                            <td><input type="number" name="team[{{ $index }}][age]" class="form-control form-control-sm" value="{{ old('team.'.$index.'.age', $member->age) }}"></td>
                                            <td>
                                                <select name="team[{{ $index }}][gender]" class="form-control form-control-sm">
                                                    <option value="Male" {{ old('team.'.$index.'.gender', $member->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                                    <option value="Female" {{ old('team.'.$index.'.gender', $member->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="team[{{ $index }}][age_category]" class="form-control form-control-sm">
                                                    <option value="Adult" {{ old('team.'.$index.'.age_category', $member->age_category) == 'Adult' ? 'selected' : '' }}>Adult</option>
                                                    <option value="Children" {{ old('team.'.$index.'.age_category', $member->age_category) == 'Children' ? 'selected' : '' }}>Children</option>
                                                </select>
                                            </td>
                                            <td><input type="text" name="team[{{ $index }}][nid_or_passport]" class="form-control form-control-sm" value="{{ old('team.'.$index.'.nid_or_passport', $member->nid_or_passport) }}"></td>
                                            <td><input type="text" name="team[{{ $index }}][profession]" class="form-control form-control-sm" value="{{ old('team.'.$index.'.profession', $member->profession) }}"></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-right">
                        <button type="submit" class="btn btn-primary btn-icon-split shadow">
                            <span class="icon text-white-50"><i class="fas fa-save"></i></span>
                            <span class="text">Save All Changes</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>
@endsection