@extends('layout.app')

@section('content')

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Department Data</h4>

        <!-- Button trigger modal Add -->
        <button type="button" class="btn btn-primary btn-rounded btn-fw mb-2" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
            Add Department
        </button>

        <!-- Modal Add -->
        <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('departments.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addDepartmentLabel">Add Department</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="department_name" class="form-label">Department Name</label>
                                <input type="text" class="form-control" id="department_name" name="department_name" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Department</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Department</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $department)
                    <tr>
                        <td>{{ $department->department_id }}</td>
                        <td>{{ $department->department_name }}</td>
                        <td>

                            <button type="button" class="btn btn-info btn-rounded btn-fw text-white" data-bs-toggle="modal" data-bs-target="#showDepartmentModal{{ $department->department_id }}">
                                Show
                            </button>

                            <button type="button" class="btn btn-warning btn-rounded btn-fw text-white" data-bs-toggle="modal" data-bs-target="#editDepartmentModal{{ $department->department_id }}">
                                Edit
                            </button>

                            <button type="button" class="btn btn-danger btn-rounded btn-fw" data-bs-toggle="modal" data-bs-target="#deleteDepartmentModal{{ $department->department_id }}">
                                Delete
                            </button>

                        </td>
                    </tr>

                    <!-- Modal Show -->
                    <div class="modal fade" id="showDepartmentModal{{ $department->department_id }}" tabindex="-1" aria-labelledby="showDepartmentLabel{{ $department->department_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showDepartmentLabel{{ $department->department_id }}">Department Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>ID:</strong> {{ $department->department_id }}</p>
                                    <p><strong>Name:</strong> {{ $department->department_name }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editDepartmentModal{{ $department->department_id }}" tabindex="-1" aria-labelledby="editDepartmentLabel{{ $department->department_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('departments.update', $department->department_id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editDepartmentLabel{{ $department->department_id }}">Edit Department</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="department_name_{{ $department->department_id }}" class="form-label">Department Name</label>
                                            <input type="text" class="form-control" id="department_name_{{ $department->department_id }}" name="department_name" value="{{ $department->department_name }}" required>
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
                    <div class="modal fade" id="deleteDepartmentModal{{ $department->department_id }}" tabindex="-1" aria-labelledby="deleteDepartmentLabel{{ $department->department_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('departments.destroy', $department->department_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteDepartmentLabel{{ $department->department_id }}">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete the department "<strong>{{ $department->department_name }}</strong>"?
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
