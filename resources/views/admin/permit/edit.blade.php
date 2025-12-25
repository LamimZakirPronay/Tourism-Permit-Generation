@extends('layouts.admin_master')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Permit Management</h1>
    <a href="{{ route('admin.permit.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Permit List
    </a>
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Modify Permit #{{ $permit->id }} [{{ $permit->group_name }}]</h6>
                <span class="badge {{ $permit->status == 'active' ? 'badge-success' : 'badge-danger' }} p-2">
                    {{ strtoupper($permit->status) }}
                </span>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.permit.update', $permit->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-12"><p class="text-primary font-weight-bold border-bottom pb-1">1. Trip Logistics & Authority</p></div>
                        <div class="form-group col-md-4">
                            <label class="small font-weight-bold">Group Name</label>
                            <input type="text" name="group_name" class="form-control" value="{{ old('group_name', $permit->group_name) }}" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small font-weight-bold">Target Restricted Area</label>
                            <input type="text" name="area_name" class="form-control" value="{{ old('area_name', $permit->area_name) }}" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small font-weight-bold">Assigned Tour Guide</label>
                            <select name="tour_guide_id" class="form-control">
                                @foreach($guides as $guide)
                                    <option value="{{ $guide->id }}" {{ $permit->tour_guide_id == $guide->id ? 'selected' : '' }}>
                                        {{ $guide->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="small font-weight-bold">Arrival Date & Time</label>
                            <input type="datetime-local" name="arrival_datetime" class="form-control" 
                                   value="{{ \Carbon\Carbon::parse($permit->arrival_datetime)->format('Y-m-d\TH:i') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="small font-weight-bold">Departure Date & Time</label>
                            <input type="datetime-local" name="departure_datetime" class="form-control" 
                                   value="{{ \Carbon\Carbon::parse($permit->departure_datetime)->format('Y-m-d\TH:i') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12"><p class="text-primary font-weight-bold border-bottom pb-1">2. Leader Contact & System Status</p></div>
                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">Leader Name</label>
                            <input type="text" name="leader_name" class="form-control" value="{{ old('leader_name', $permit->leader_name) }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">Leader NID</label>
                            <input type="text" name="leader_nid" class="form-control" value="{{ old('leader_nid', $permit->leader_nid) }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $permit->email) }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">Phone Number</label>
                            <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $permit->contact_number) }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="small font-weight-bold">Permit Status</label>
                            <select name="status" class="form-control">
                                <option value="active" {{ $permit->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="completed" {{ $permit->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $permit->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="small font-weight-bold">Payment Status</label>
                            <select name="payment_status" class="form-control">
                                <option value="completed" {{ $permit->payment_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="pending" {{ $permit->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12"><p class="text-primary font-weight-bold border-bottom pb-1">3. Detailed Team Member List</p></div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm" width="100%" cellspacing="0">
                                    <thead class="bg-gray-100 text-dark small font-weight-bold">
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
                                                <input type="text" name="team[{{ $index }}][name]" class="form-control form-control-sm" value="{{ $member->name }}">
                                            </td>
                                            <td>
                                                <input type="text" name="team[{{ $index }}][fathers_name]" class="form-control form-control-sm" value="{{ $member->fathers_name }}">
                                            </td>
                                            <td>
                                                <input type="number" name="team[{{ $index }}][age]" class="form-control form-control-sm" value="{{ $member->age }}">
                                            </td>
                                            <td>
                                                <select name="team[{{ $index }}][gender]" class="form-control form-control-sm">
                                                    <option value="Male" {{ $member->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                    <option value="Female" {{ $member->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="team[{{ $index }}][age_category]" class="form-control form-control-sm">
                                                    <option value="Adult" {{ $member->age_category == 'Adult' ? 'selected' : '' }}>Adult</option>
                                                    <option value="Children" {{ $member->age_category == 'Children' ? 'selected' : '' }}>Children</option>
                                                    <option value="Infant" {{ $member->age_category == 'Infant' ? 'selected' : '' }}>Infant</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="team[{{ $index }}][nid_or_passport]" class="form-control form-control-sm" value="{{ $member->nid_or_passport }}">
                                            </td>
                                            <td>
                                                <input type="text" name="team[{{ $index }}][profession]" class="form-control form-control-sm" value="{{ $member->profession }}">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-right">
                        <button type="submit" class="btn btn-primary btn-icon-split shadow">
                            <span class="icon text-white-50"><i class="fas fa-check"></i></span>
                            <span class="text">Update All Permit Records</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection