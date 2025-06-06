@extends('layout.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">Academic Management</h4>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Filter Tabs --}}
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link {{ request('tab') == null ? 'active' : '' }}"
                        href="{{ route('admin.academics.index') }}">
                        <i class="bi bi-list"></i> Academic Years
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('tab') == 'student_period' ? 'active' : '' }}"
                        href="{{ route('admin.academics.index', ['tab' => 'student_period']) }}">
                        <i class="bi bi-person"></i> Student Periods
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('tab') == 'period' ? 'active' : '' }}"
                        href="{{ route('admin.academics.index', ['tab' => 'period']) }}">
                        <i class="bi bi-calendar"></i> Periods
                    </a>
                </li>
            </ul>

            {{-- Tombol Add --}}
            <button type="button" class="btn btn-primary btn-rounded btn-fw mb-3" data-bs-toggle="modal"
                data-bs-target="#addAcademicYearModal">
                <i class="bi bi-plus-circle me-2"></i> Add Academic Year
            </button>

            {{-- === Academic Year Section === --}}
            @if (!request('tab'))
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Academic Year</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($academic_years as $index => $year)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $year->academic_year }}</td>
                                    <td>{{ $year->start_date }}</td>
                                    <td>{{ $year->end_date }}</td>
                                    <td>
                                        {{-- Show --}}
                                        <button class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#showAcademicYearModal{{ $year->academic_year_id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        {{-- Edit --}}
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editAcademicYearModal{{ $year->academic_year_id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        {{-- Delete --}}
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteAcademicYearModal{{ $year->academic_year_id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal Show Academic Year --}}
                                <div class="modal fade" id="showAcademicYearModal{{ $year->academic_year_id }}"
                                    tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Academic Year Detail</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Academic Year:</strong> {{ $year->academic_year }}</p>
                                                <p><strong>Start Date:</strong> {{ $year->start_date }}</p>
                                                <p><strong>End Date:</strong> {{ $year->end_date }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal Edit Academic Year --}}
                                <div class="modal fade" id="editAcademicYearModal{{ $year->academic_year_id }}"
                                    tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form action="{{ route('admin.academic_years.update', $year->academic_year_id) }}"
                                            method="POST" class="modal-content">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Academic Year</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Academic Year</label>
                                                    <input type="text" name="academic_year" class="form-control"
                                                        value="{{ $year->academic_year }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Start Date</label>
                                                    <input type="date" name="start_date" class="form-control"
                                                        value="{{ $year->start_date }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">End Date</label>
                                                    <input type="date" name="end_date" class="form-control"
                                                        value="{{ $year->end_date }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-warning">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                {{-- Modal Delete Academic Year --}}
                                <div class="modal fade" id="deleteAcademicYearModal{{ $year->academic_year_id }}"
                                    tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form action="{{ route('admin.academic_years.destroy', $year->academic_year_id) }}"
                                            method="POST" class="modal-content">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete Academic Year</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this academic year?
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $academic_years->links() }}
                </div>
            @elseif (request('tab') == 'student_period')
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Student Name</th>
                                <th>Period</th>
                                <th>IPK</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($student_periods as $index => $studentPeriod)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $studentPeriod->detailStudent->user->user_name }}</td>
                                    <td>{{ $studentPeriod->period->period_name }}</td>
                                    <td>{{ $studentPeriod->ipk }}</td>
                                    <td>
                                        <!-- Tombol Show/Edit/Delete -->
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#showStudentPeriodModal{{ $studentPeriod->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editStudentPeriodModal{{ $studentPeriod->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteStudentPeriodModal{{ $studentPeriod->student_period_id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Show -->
                                <div class="modal fade" id="showStudentPeriodModal{{ $studentPeriod->student_period_id }}"
                                    tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Student Period Detail</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Student:</strong>
                                                    {{ $studentPeriod->detailStudent->user->user_name }}</p>
                                                <p><strong>Period:</strong> {{ $studentPeriod->period->period_name }}</p>
                                                <p><strong>IPK:</strong> {{ $studentPeriod->ipk }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editStudentPeriodModal{{ $studentPeriod->student_period_id }}"
                                    tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form action="{{ route('admin.student_periods.update', $studentPeriod->student_period_id) }}"
                                            method="POST" class="modal-content">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Student Period</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">IPK</label>
                                                    <input type="text" name="ipk" class="form-control"
                                                        value="{{ $studentPeriod->ipk }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-warning">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Modal Delete -->
                                <div class="modal fade" id="deleteStudentPeriodModal{{ $studentPeriod->student_period_id }}"
                                    tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form action="{{ route('admin.student_periods.destroy', $studentPeriod->student_period_id) }}"
                                            method="POST" class="modal-content">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete Student Period</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this student period?
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $student_periods->links() }}
                    </div>
                </div>
                @elseif (request('tab') == 'period')
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Period Name</th>
                                <th>Academic Year</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($periods as $index => $period)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $period->period_name }}</td>
                                    <td>{{ $period->academic_year->academic_year }}</td>
                                    <td>{{ $period->start_date }}</td>
                                    <td>{{ $period->end_date }}</td>
                                    <td>
                                        <!-- Tombol Show/Edit/Delete -->
                                        <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#showPeriodModal{{ $period->period_id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPeriodModal{{ $period->period_id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletePeriodModal{{ $period->period_id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Show -->
                                <div class="modal fade" id="showPeriodModal{{ $period->period_id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Period Detail</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Period:</strong> {{ $period->period_name }}</p>
                                                <p><strong>Academic Year:</strong> {{ $period->academic_year->academic_year }}</p>
                                                <p><strong>Start Date:</strong> {{ $period->start_date }}</p>
                                                <p><strong>End Date:</strong> {{ $period->end_date }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editPeriodModal{{ $period->period_id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form action="{{ route('admin.periods.update', $period->period_id) }}" method="POST" class="modal-content">

                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Period</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Period Name</label>
                                                    <input type="text" name="period_name" class="form-control" value="{{ $period->period_name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Start Date</label>
                                                    <input type="date" name="start_date" class="form-control" value="{{ $period->start_date }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">End Date</label>
                                                    <input type="date" name="end_date" class="form-control" value="{{ $period->end_date }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-warning">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Modal Delete -->
                                <div class="modal fade" id="deletePeriodModal{{ $period->period_id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form action="{{ route('admin.periods.destroy', $period->period_id) }}" method="POST" class="modal-content">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete Period</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this period?
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $periods->links() }}
                    </div>
                </div>
            @endif



            {{-- Modal Add Academic Year --}}
            <div class="modal fade" id="addAcademicYearModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="{{ route('admin.academic_years.store') }}" method="POST" class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Add Academic Year</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Academic Year</label>
                                <input type="text" name="academic_year" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
