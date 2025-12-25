<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Closing Panel | Tourism System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8fafc; font-family: 'Inter', sans-serif; }
        .card-table { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .status-badge { padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 600; }
    </style>
</head>
<body>

    <div class="container py-5">
        <div class="row mb-4 align-items-center">
            <div class="col-md-7">
                <h2 class="fw-bold text-dark">🏁 Trip Closing Management</h2>
                <p class="text-muted">Review and close permits based on departure dates.</p>
            </div>
            <div class="col-md-5">
                <form action="{{ route('admin.permits.closing-panel') }}" method="GET" class="card p-3 border-0 shadow-sm">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-calendar-event"></i></span>
                        <input type="date" name="date" class="form-control border-start-0" value="{{ $date }}" onchange="this.form.submit()">
                    </div>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
        @endif

        <div class="card card-table">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Group Details</th>
                            <th>Guide</th>
                            <th>Departure Time</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permits as $permit)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $permit->group_name }}</div>
                                <div class="small text-muted">Lead: {{ $permit->leader_name }}</div>
                            </td>
                            <td>{{ $permit->tourGuide->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-info-subtle text-info status-badge">
                                    {{ \Carbon\Carbon::parse($permit->departure_datetime)->format('h:i A') }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.permits.close', $permit->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success rounded-pill px-4">
                                        <i class="bi bi-check-lg"></i> Complete Trip
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">No permits scheduled for closure on this date.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>