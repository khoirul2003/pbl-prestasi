@extends('layout.app')

@section('content')

<div class="card shadow-sm rounded-3 mb-4">
    <div class="card-body">
        <h4 class="card-title mb-3">Period Data</h4>

        <a href="{{ route('periods.create') }}" class="btn btn-primary btn-rounded btn-fw mb-2">
            <i class="bi bi-plus-circle me-2"></i> Add Period
        </a>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Academic Year</th>
                        <th>Period Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($periods as $period)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $period->academic_year->academic_year ?? '-' }}</td>
                            <td>{{ $period->period_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($period->start_date)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($period->end_date)->format('d-m-Y') }}</td>
                            <td class="d-flex">

                                <a href="{{ route('periods.edit', $period->period_id) }}" class="btn btn-warning btn-sm btn-rounded me-2" data-bs-toggle="tooltip" title="Edit Period">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('periods.destroy', $period->period_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-rounded" onclick="return confirm('Are you sure?')" data-bs-toggle="tooltip" title="Delete Period">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $periods->links() }}
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Activate tooltips
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush
