@extends('layout.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">Academic Year Management</h4>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

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
                                        <button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#showAcademicYearModal{{ $year->academic_year_id }}">
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
                                <div class="modal fade" id="editAcademicYearModal{{ $year->academic_year_id }}" tabindex="-1" aria-labelledby="editAcademicYearLabel{{ $year->academic_year_id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <form action="{{ route('admin.academic_years.update', $year->academic_year_id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editAcademicYearLabel{{ $year->academic_year_id }}">Edit Academic Year</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                            <label for="academic_year_{{ $year->academic_year_id }}" class="form-label">Academic Year</label>
                                            <input type="text"
                                                    class="form-control @error('academic_year') is-invalid @enderror"
                                                    id="academic_year_{{ $year->academic_year_id }}"
                                                    name="academic_year"
                                                    value="{{ old('academic_year', $year->academic_year) }}"
                                                    required>
                                            @error('academic_year')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            </div>
                                            <div class="mb-3">
                                            <label for="start_date_{{ $year->academic_year_id }}" class="form-label">Start Date</label>
                                            <input type="date"
                                                    class="form-control @error('start_date') is-invalid @enderror"
                                                    id="start_date_{{ $year->academic_year_id }}"
                                                    name="start_date"
                                                    value="{{ old('start_date', \Carbon\Carbon::parse($year->start_date)->format('Y-m-d')) }}"
                                                    required>
                                            @error('start_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            </div>
                                            <div class="mb-3">
                                            <label for="end_date_{{ $year->academic_year_id }}" class="form-label">End Date</label>
                                            <input type="date"
                                                    class="form-control @error('end_date') is-invalid @enderror"
                                                    id="end_date_{{ $year->academic_year_id }}"
                                                    name="end_date"
                                                    value="{{ old('end_date', \Carbon\Carbon::parse($year->end_date)->format('Y-m-d')) }}"
                                                    required>
                                            @error('end_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-warning">Update</button>
                                        </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>

                                {{-- Modal Delete Academic Year --}}
                                <div class="modal fade" id="deleteAcademicYearModal{{ $year->academic_year_id }}" tabindex="-1" aria-labelledby="deleteAcademicYearLabel{{ $year->academic_year_id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('admin.academic_years.destroy', $year->academic_year_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteAcademicYearLabel{{ $year->academic_year_id }}">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">Are you sure you want to delete "<strong>{{ $year->academic_year }}</strong>"?</div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

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

            <div class="mt-3">
                {{ $academic_years->links() }}
            </div>

        </div>
    </div>
@endif
@endsection
