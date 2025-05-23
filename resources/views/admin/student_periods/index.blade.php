@extends('layout.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Student Periods</h4>

            <div class="card-body d-flex align-items-center justify-content-between mb-3 ">
                <a href="{{ route('student_periods.create') }}" class="btn btn-primary btn-sm btn-rounded btn-fw">Add Student
                    Period</a>

                <form id="searchForm" method="GET" action="{{ route('student_periods.index') }}"
                    class="d-flex align-items-center" style="gap: 0.5rem;">
                    <input type="search" name="search" id="searchInput" value="{{ request('search') }}"
                        class="form-control form-control-sm rounded-pill" placeholder="Search" style="width: 200px;">
                </form>
            </div>
            {{-- <a href="{{ route('student_periods.create') }}" class="btn btn-primary btn-rounded btn-fw mb-2">Add Student Period</a> --}}

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
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
                                <td>
                                    <a href="{{ route('student_periods.edit', $studentPeriod->student_period_id) }}"
                                        class="btn btn-warning btn-rounded btn-fw">Edit</a>

                                    <form
                                        action="{{ route('student_periods.destroy', $studentPeriod->student_period_id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-rounded btn-fw"
                                            onclick="return confirm('Are you sure want to delete this record?')">Delete</button>
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

            <div class="mt-3">
                {{ $studentPeriods->links() }}
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
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
@endsection
