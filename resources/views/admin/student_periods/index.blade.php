@extends('layout.app')

@section('content')
<div class="card shadow-sm rounded-3 mb-4">
    <div class="card-body">
        <h4 class="card-title mb-3">Student Periods</h4>

        <!-- Action buttons: Add and Search -->
        <div class="card-body d-flex align-items-center justify-content-between mb-3">
            <a href="{{ route('student_periods.create') }}" class="btn btn-primary btn-rounded btn-fw">
                <i class="bi bi-plus-circle me-2"></i> Add Student Period
            </a>

            <form id="searchForm" method="GET" action="{{ route('student_periods.index') }}" class="d-flex align-items-center" style="gap: 0.5rem;">
                <input type="search" name="search" id="searchInput" value="{{ request('search') }}" class="form-control form-control-sm rounded-pill" placeholder="Search" style="width: 200px;">
            </form>
        </div>

        <!-- Table of Student Periods -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Student Name</th>
                        <th>Username</th>
                        <th>Period</th>
                        <th>IPK</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($studentPeriods as $studentPeriod)
                        <tr>
                            <td>{{ $studentPeriods->firstItem() + $loop->index }}</td>
                            <td>{{ $studentPeriod->detailStudent->user->user_name ?? '-' }}</td>
                            <td>{{ $studentPeriod->detailStudent->user->user_username ?? '-' }}</td>
                            <td>{{ $studentPeriod->period->period_name ?? '-' }}</td>
                            <td>{{ number_format($studentPeriod->ipk, 2) }}</td>
                            <td class="d-flex">
                                <!-- Edit Button -->
                                <a href="{{ route('student_periods.edit', $studentPeriod->student_period_id) }}" class="btn btn-warning btn-sm btn-rounded me-2" data-bs-toggle="tooltip" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('student_periods.destroy', $studentPeriod->student_period_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-rounded" onclick="return confirm('Are you sure want to delete this record?')" data-bs-toggle="tooltip" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No Student Period data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $studentPeriods->links() }}
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Enable tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });

    // Debounced search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        let debounceTimeout = null;

        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
                document.getElementById('searchForm').submit();
            }, 500);
        });
    });
</script>
@endpush
