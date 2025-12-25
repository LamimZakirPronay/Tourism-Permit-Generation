<!DOCTYPE html>
<html lang="en">
<head>
    <title>Assign Guide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <div class="card p-4 shadow-sm">
            <h1 class="mb-4">Assign Guide to Permit #{{ $permit->id }}</h1>

            <div class="mb-4">
                <p><strong>Group:</strong> {{ $permit->group_name }} ({{ $permit->total_members }} members)</p>
                <p><strong>Visiting:</strong> {{ $permit->area_name }} on {{ \Carbon\Carbon::parse($permit->visit_date)->format('F j, Y') }}</p>
                <p><strong>Current Guide:</strong> <span class="badge bg-{{ $permit->guide ? 'primary' : 'secondary' }}">{{ $permit->guide->name ?? 'None' }}</span></p>
            </div>

            <form action="{{ route('admin.permits.update', $permit->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Required for the Route::put method --}}

                <div class="mb-3">
                    <label for="tour_guide_id" class="form-label">Select Tour Guide</label>
                    <select class="form-select @error('tour_guide_id') is-invalid @enderror" id="tour_guide_id" name="tour_guide_id">
                        <option value="">-- Choose Guide (Optional) --</option>
                        @foreach ($guides as $id => $name)
                            <option value="{{ $id }}" {{ old('tour_guide_id', $permit->tour_guide_id) == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tour_guide_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Save Assignment</button>
                    <a href="{{ route('admin.permits.index') }}" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>