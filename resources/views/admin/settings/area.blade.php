@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Entry Restricted Areas</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.areas.store') }}" method="POST" class="row g-3 mb-4">
                        @csrf
                        <div class="col-md-8">
                            <input type="text" name="name" class="form-control" placeholder="Enter Area Name (e.g. Sundarbans East Zone)" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success w-100">Add Area</button>
                        </div>
                    </form>

                    <hr>

                    <table class="table table-hover mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Area Name</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($areas as $index => $area)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $area->name }}</td>
                                <td>
                                    <span class="badge {{ $area->is_active ? 'bg-primary' : 'bg-secondary' }}">
                                        {{ $area->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.areas.destroy', $area->id) }}" method="POST" onsubmit="return confirm('Delete this area?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No areas found. Please add one above.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection