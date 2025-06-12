@extends('layout.app')

@section('content')

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h4 class="card-title mb-4">Academic Year Data</h4>

        <!-- Button trigger modal Add -->
        <button type="button" class="btn btn-primary btn-rounded btn-fw mb-3" data-bs-toggle="modal" data-bs-target="#addAcademicYearModal">
            <i class="bi bi-plus-circle me-2"></i> Add Academic Year
        </button>

        <!-- Modal Add Academic Year -->
        <div class="modal fade" id="addAcademicYearModal" tabindex="-1" aria-labelledby="addAcademicYearLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('admin.academic_years.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addAcademicYearLabel">Add Academic Year</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="academic_year" class="form-label">Academic Year</label>
                                <input type="text" class="form-control" id="academic_year" name="academic_year" required>
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Academic Year</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table for Academic Year -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Academic Year</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($academic_years as $academic_year)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $academic_year->academic_year }}</td>
                        <td>{{ $academic_year->start_date }}</td>
                        <td>{{ $academic_year->end_date }}</td>
                        <td>
                            <!-- Show Button -->
                            <button type="button" class="btn btn-info btn-rounded btn-sm text-white" data-bs-toggle="modal" data-bs-target="#showAcademicYearModal{{ $academic_year->academic_year_id }}">
                                <i class="bi bi-eye"></i> Show
                            </button>

                            <!-- Edit Button -->
                            <button type="button" class="btn btn-warning btn-rounded btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editAcademicYearModal{{ $academic_year->academic_year_id }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>

                            <!-- Delete Button -->
                            <button type="button" class="btn btn-danger btn-rounded btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAcademicYearModal{{ $academic_year->academic_year_id }}">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Show -->
                    <div class="modal fade" id="showAcademicYearModal{{ $academic_year->academic_year_id }}" tabindex="-1" aria-labelledby="showAcademicYearLabel{{ $academic_year->academic_year_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showAcademicYearLabel{{ $academic_year->academic_year_id }}">Academic Year Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>ID:</strong> {{ $academic_year->academic_year_id }}</p>
                                    <p><strong>Academic Year:</strong> {{ $academic_year->academic_year }}</p>
                                    <p><strong>Start Date:</strong> {{ $academic_year->start_date }}</p>
                                    <p><strong>End Date:</strong> {{ $academic_year->end_date }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editAcademicYearModal{{ $academic_year->academic_year_id }}" tabindex="-1" aria-labelledby="editAcademicYearLabel{{ $academic_year->academic_year_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.academic_years.update', $academic_year->academic_year_id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editAcademicYearLabel{{ $academic_year->academic_year_id }}">Edit Academic Year</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="academic_year_{{ $academic_year->academic_year_id }}" class="form-label">Academic Year</label>
                                            <input type="text" class="form-control" id="academic_year_{{ $academic_year->academic_year_id }}" name="academic_year" value="{{ $academic_year->academic_year }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="start_date_{{ $academic_year->academic_year_id }}" class="form-label">Start Date</label>
                                            <input type="date" class="form-control" id="start_date_{{ $academic_year->academic_year_id }}" name="start_date" value="{{ $academic_year->start_date }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="end_date_{{ $academic_year->academic_year_id }}" class="form-label">End Date</label>
                                            <input type="date" class="form-control" id="end_date_{{ $academic_year->academic_year_id }}" name="end_date" value="{{ $academic_year->end_date }}" required>
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

                    <!-- Modal Delete -->
                    <div class="modal fade" id="deleteAcademicYearModal{{ $academic_year->academic_year_id }}" tabindex="-1" aria-labelledby="deleteAcademicYearLabel{{ $academic_year->academic_year_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.academic_years.destroy', $academic_year->academic_year_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteAcademicYearLabel{{ $academic_year->academic_year_id }}">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete the academic year "<strong>{{ $academic_year->academic_year }}</strong>"?
                                    </div>
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
    </div>
</div>

@endsection
