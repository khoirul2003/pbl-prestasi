@extends('layout.app')

@section('content')

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h4 class="card-title mb-4">Study Program Data</h4>

        <!-- Button trigger modal Add -->
        <button type="button" class="btn btn-primary btn-rounded btn-fw mb-3" data-bs-toggle="modal" data-bs-target="#addStudyProgramModal">
            <i class="bi bi-plus-circle me-2"></i> Add Study Program
        </button>

        <!-- Modal Add Study Program -->
        <div class="modal fade" id="addStudyProgramModal" tabindex="-1" aria-labelledby="addStudyProgramLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('study_programs.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addStudyProgramLabel">Add Study Program</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="department_id" class="form-label">Department</label>
                                <select name="department_id" id="department_id" class="form-select" required>
                                    <option value="">-- Select Department --</option>
                                    @foreach(\App\Models\Department::all() as $department)
                                        <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="study_program_name" class="form-label">Study Program Name</label>
                                <input type="text" class="form-control" id="study_program_name" name="study_program_name" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Study Program</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table for Study Programs -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Department</th>
                        <th>Study Program</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($study_programs as $study_program)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $study_program->departments->department_name }}</td>
                        <td>{{ $study_program->study_program_name }}</td>
                        <td>
                            <!-- Show Button -->
                            <button type="button" class="btn btn-info btn-rounded btn-sm text-white" data-bs-toggle="modal" data-bs-target="#showStudyProgramModal{{ $study_program->study_program_id }}">
                                <i class="bi bi-eye"></i> Show
                            </button>

                            <!-- Edit Button -->
                            <button type="button" class="btn btn-warning btn-rounded btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editStudyProgramModal{{ $study_program->study_program_id }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>

                            <!-- Delete Button -->
                            <button type="button" class="btn btn-danger btn-rounded btn-sm" data-bs-toggle="modal" data-bs-target="#deleteStudyProgramModal{{ $study_program->study_program_id }}">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Show -->
                    <div class="modal fade" id="showStudyProgramModal{{ $study_program->study_program_id }}" tabindex="-1" aria-labelledby="showStudyProgramLabel{{ $study_program->study_program_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showStudyProgramLabel{{ $study_program->study_program_id }}">Study Program Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>ID:</strong> {{ $study_program->study_program_id }}</p>
                                    <p><strong>Department:</strong> {{ $study_program->departments->department_name }}</p>
                                    <p><strong>Study Program:</strong> {{ $study_program->study_program_name }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editStudyProgramModal{{ $study_program->study_program_id }}" tabindex="-1" aria-labelledby="editStudyProgramLabel{{ $study_program->study_program_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('study_programs.update', $study_program->study_program_id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editStudyProgramLabel{{ $study_program->study_program_id }}">Edit Study Program</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="department_id_{{ $study_program->study_program_id }}" class="form-label">Department</label>
                                            <select name="department_id" id="department_id_{{ $study_program->study_program_id }}" class="form-select" required>
                                                <option value="">-- Select Department --</option>
                                                @foreach(\App\Models\Department::all() as $department)
                                                    <option value="{{ $department->department_id }}" {{ $study_program->department_id == $department->department_id ? 'selected' : '' }}>{{ $department->department_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="study_program_name_{{ $study_program->study_program_id }}" class="form-label">Study Program Name</label>
                                            <input type="text" class="form-control" id="study_program_name_{{ $study_program->study_program_id }}" name="study_program_name" value="{{ $study_program->study_program_name }}" required>
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
                    <div class="modal fade" id="deleteStudyProgramModal{{ $study_program->study_program_id }}" tabindex="-1" aria-labelledby="deleteStudyProgramLabel{{ $study_program->study_program_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('study_programs.destroy', $study_program->study_program_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteStudyProgramLabel{{ $study_program->study_program_id }}">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete the study program "<strong>{{ $study_program->study_program_name }}</strong>"?
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
