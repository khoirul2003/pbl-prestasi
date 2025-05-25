@extends('layout.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Supervisor Data</h4>

            <!-- Button Add Supervisor -->
            <button type="button" class="btn btn-primary btn-rounded btn-fw mb-2" data-bs-toggle="modal"
                data-bs-target="#addSupervisorModal">
                Add Supervisor
            </button>

            <!-- Modal Add Supervisor -->
            <div class="modal fade" id="addSupervisorModal" tabindex="-1" aria-labelledby="addSupervisorLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form action="{{ route('supervisors.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addSupervisorLabel">Add Supervisor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="user_name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="user_name" name="user_name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="user_username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="user_username" name="user_username"
                                            required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="user_password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="user_password" name="user_password"
                                            required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}$"
                                            title="Passwords must be at least 8 characters long, contain uppercase letters, lowercase letters, numbers, and symbols such as @$!%*#?" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="user_password_confirmation" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="user_password_confirmation"
                                            name="user_password_confirmation" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="department_id" class="form-label">Department</label>
                                    <select name="department_id" id="department_id" class="form-select" required>
                                        <option value="" disabled selected>Select Department</option>
                                        @foreach (\App\Models\Department::all() as $department)
                                            <option value="{{ $department->department_id }}">
                                                {{ $department->department_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="detail_supervisor_nip" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="detail_supervisor_nip"
                                        name="detail_supervisor_nip" required>
                                </div>

                                <div class="mb-3">
                                    <label for="detail_supervisor_gender" class="form-label">Gender</label>
                                    <select name="detail_supervisor_gender" id="detail_supervisor_gender"
                                        class="form-select" required>
                                        <option value="" disabled selected>Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="detail_supervisor_dob" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="detail_supervisor_dob"
                                        name="detail_supervisor_dob" required>
                                </div>

                                <div class="mb-3">
                                    <label for="detail_supervisor_address" class="form-label">Address</label>
                                    <textarea class="form-control" id="detail_supervisor_address" name="detail_supervisor_address" rows="2" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="detail_supervisor_phone_no" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="detail_supervisor_phone_no"
                                        name="detail_supervisor_phone_no" required>
                                </div>

                                <div class="mb-3">
                                    <label for="detail_supervisor_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="detail_supervisor_email"
                                        name="detail_supervisor_email" required>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Add Supervisor</button>
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
                            <th>Name</th>
                            <th>Username</th>
                            <th>NIP</th>
                            <th>Department</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($supervisors as $supervisor)
                            <tr>
                                <td>{{ $supervisors->firstItem() + $loop->index }}</td>
                                <td>{{ $supervisor->user_name }}</td>
                                <td>{{ $supervisor->user_username }}</td>
                                <td>{{ $supervisor->detailSupervisor->detail_supervisor_nip ?? '-' }}</td>
                                <td>{{ $supervisor->detailSupervisor->department->department_name ?? '-' }}</td>
                                <td>{{ ucfirst($supervisor->detailSupervisor->detail_supervisor_gender ?? '-') }}</td>
                                <td>{{ $supervisor->detailSupervisor->detail_supervisor_email ?? '-' }}</td>
                                <td>{{ $supervisor->detailSupervisor->detail_supervisor_phone_no ?? '-' }}</td>
                                <td>
                                    <!-- Show -->
                                    <button type="button" class="btn btn-info btn-rounded btn-fw text-white"
                                        data-bs-toggle="modal"
                                        data-bs-target="#showSupervisorModal{{ $supervisor->user_id }}">
                                        Show
                                    </button>
                                    <!-- Edit -->
                                    <button type="button" class="btn btn-warning btn-rounded btn-fw text-white"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editSupervisorModal{{ $supervisor->user_id }}">
                                        Edit
                                    </button>
                                    <!-- Delete -->
                                    <button type="button" class="btn btn-danger btn-rounded btn-fw"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteSupervisorModal{{ $supervisor->user_id }}">
                                        Delete
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Show Supervisor -->
                            <div class="modal fade" id="showSupervisorModal{{ $supervisor->user_id }}" tabindex="-1"
                                aria-labelledby="showSupervisorLabel{{ $supervisor->user_id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="showSupervisorLabel{{ $supervisor->user_id }}">
                                                Supervisor Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4 text-center">
                                                    @if ($supervisor->detailSupervisor->detail_supervisor_photo)
                                                        <img src="{{ asset('photos/supervisors/' . $supervisor->detailSupervisor->detail_supervisor_photo) }}"
                                                            alt="Photo" class="img-fluid rounded shadow-sm mb-3"
                                                            style="max-height: 250px; object-fit: cover;">
                                                    @else
                                                        <div class="border rounded d-flex align-items-center justify-content-center mb-3"
                                                            style="height: 250px; background-color: #f8f9fa; color: #6c757d;">
                                                            No Photo
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-8">
                                                    <dl class="row">
                                                        <dt class="col-sm-4">Name</dt>
                                                        <dd class="col-sm-8">{{ $supervisor->user_name }}</dd>

                                                        <dt class="col-sm-4">Username</dt>
                                                        <dd class="col-sm-8">{{ $supervisor->user_username }}</dd>

                                                        <dt class="col-sm-4">NIP</dt>
                                                        <dd class="col-sm-8">
                                                            {{ $supervisor->detailSupervisor->detail_supervisor_nip ?? '-' }}
                                                        </dd>

                                                        <dt class="col-sm-4">Department</dt>
                                                        <dd class="col-sm-8">
                                                            {{ $supervisor->detailSupervisor->department->department_name ?? '-' }}
                                                        </dd>

                                                        <dt class="col-sm-4">Gender</dt>
                                                        <dd class="col-sm-8">
                                                            {{ ucfirst($supervisor->detailSupervisor->detail_supervisor_gender ?? '-') }}
                                                        </dd>

                                                        <dt class="col-sm-4">Date of Birth</dt>
                                                        <dd class="col-sm-8">
                                                            {{ $supervisor->detailSupervisor->detail_supervisor_dob ?? '-' }}
                                                        </dd>

                                                        <dt class="col-sm-4">Address</dt>
                                                        <dd class="col-sm-8">
                                                            {{ $supervisor->detailSupervisor->detail_supervisor_address ?? '-' }}
                                                        </dd>

                                                        <dt class="col-sm-4">Phone</dt>
                                                        <dd class="col-sm-8">
                                                            {{ $supervisor->detailSupervisor->detail_supervisor_phone_no ?? '-' }}
                                                        </dd>

                                                        <dt class="col-sm-4">Email</dt>
                                                        <dd class="col-sm-8">
                                                            {{ $supervisor->detailSupervisor->detail_supervisor_email ?? '-' }}
                                                        </dd>
                                                    </dl>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Edit Supervisor -->
                            <div class="modal fade" id="editSupervisorModal{{ $supervisor->user_id }}" tabindex="-1"
                                aria-labelledby="editSupervisorLabel{{ $supervisor->user_id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <form action="{{ route('supervisors.update', $supervisor->user_id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="editSupervisorLabel{{ $supervisor->user_id }}">Edit Supervisor
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="user_name_{{ $supervisor->user_id }}"
                                                            class="form-label">Name</label>
                                                        <input type="text" class="form-control"
                                                            id="user_name_{{ $supervisor->user_id }}" name="user_name"
                                                            value="{{ $supervisor->user_name }}" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="user_username_{{ $supervisor->user_id }}"
                                                            class="form-label">Username</label>
                                                        <input type="text" class="form-control"
                                                            id="user_username_{{ $supervisor->user_id }}"
                                                            name="user_username" value="{{ $supervisor->user_username }}"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="user_password_{{ $supervisor->user_id }}"
                                                            class="form-label">Password (leave blank to keep
                                                            current)</label>
                                                        <input type="password" class="form-control"
                                                            id="user_password_{{ $supervisor->user_id }}"
                                                            name="user_password" required
                                                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}$"
                                                            title="Passwords must be at least 8 characters long, contain uppercase letters, lowercase letters, numbers, and symbols such as @$!%*#?">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="user_password_confirmation_{{ $supervisor->user_id }}"
                                                            class="form-label">Confirm Password</label>
                                                        <input type="password" class="form-control"
                                                            id="user_password_confirmation_{{ $supervisor->user_id }}"
                                                            name="user_password_confirmation">
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="department_id_{{ $supervisor->user_id }}"
                                                        class="form-label">Department</label>
                                                    <select name="department_id"
                                                        id="department_id_{{ $supervisor->user_id }}" class="form-select"
                                                        required>
                                                        <option value="" disabled>Select Department</option>
                                                        @foreach (\App\Models\Department::all() as $department)
                                                            <option value="{{ $department->department_id }}"
                                                                @if (($supervisor->detailSupervisor->department_id ?? '') == $department->department_id) selected @endif>
                                                                {{ $department->department_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="detail_supervisor_nip_{{ $supervisor->user_id }}"
                                                        class="form-label">NIP</label>
                                                    <input type="text" class="form-control"
                                                        id="detail_supervisor_nip_{{ $supervisor->user_id }}"
                                                        name="detail_supervisor_nip"
                                                        value="{{ $supervisor->detailSupervisor->detail_supervisor_nip ?? '' }}"
                                                        required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="detail_supervisor_gender_{{ $supervisor->user_id }}"
                                                        class="form-label">Gender</label>
                                                    <select name="detail_supervisor_gender"
                                                        id="detail_supervisor_gender_{{ $supervisor->user_id }}"
                                                        class="form-select" required>
                                                        <option value="male"
                                                            @if (($supervisor->detailSupervisor->detail_supervisor_gender ?? '') == 'male') selected @endif>Male</option>
                                                        <option value="female"
                                                            @if (($supervisor->detailSupervisor->detail_supervisor_gender ?? '') == 'female') selected @endif>Female
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="detail_supervisor_dob_{{ $supervisor->user_id }}"
                                                        class="form-label">Date of Birth</label>
                                                    <input type="date" class="form-control"
                                                        id="detail_supervisor_dob_{{ $supervisor->user_id }}"
                                                        name="detail_supervisor_dob"
                                                        value="{{ $supervisor->detailSupervisor->detail_supervisor_dob ?? '' }}"
                                                        required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="detail_supervisor_address_{{ $supervisor->user_id }}"
                                                        class="form-label">Address</label>
                                                    <textarea class="form-control" id="detail_supervisor_address_{{ $supervisor->user_id }}"
                                                        name="detail_supervisor_address" rows="2" required>{{ $supervisor->detailSupervisor->detail_supervisor_address ?? '' }}</textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="detail_supervisor_phone_no_{{ $supervisor->user_id }}"
                                                        class="form-label">Phone Number</label>
                                                    <input type="text" class="form-control"
                                                        id="detail_supervisor_phone_no_{{ $supervisor->user_id }}"
                                                        name="detail_supervisor_phone_no"
                                                        value="{{ $supervisor->detailSupervisor->detail_supervisor_phone_no ?? '' }}"
                                                        required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="detail_supervisor_email_{{ $supervisor->user_id }}"
                                                        class="form-label">Email</label>
                                                    <input type="email" class="form-control"
                                                        id="detail_supervisor_email_{{ $supervisor->user_id }}"
                                                        name="detail_supervisor_email"
                                                        value="{{ $supervisor->detailSupervisor->detail_supervisor_email ?? '' }}"
                                                        required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="detail_supervisor_photo_{{ $supervisor->user_id }}"
                                                        class="form-label">Photo</label>
                                                    <input type="file" class="form-control"
                                                        id="detail_supervisor_photo_{{ $supervisor->user_id }}"
                                                        name="detail_supervisor_photo" accept="image/*">
                                                    @if ($supervisor->detailSupervisor->detail_supervisor_photo)
                                                        <img src="{{ asset('photos/supervisors/' . $supervisor->detailSupervisor->detail_supervisor_photo) }}"
                                                            alt="Photo" class="img-fluid mt-2"
                                                            style="max-width: 150px;">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-warning">Update Supervisor</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Modal Delete Supervisor -->
                            <div class="modal fade" id="deleteSupervisorModal{{ $supervisor->user_id }}" tabindex="-1"
                                aria-labelledby="deleteSupervisorLabel{{ $supervisor->user_id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('supervisors.destroy', $supervisor->user_id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="deleteSupervisorLabel{{ $supervisor->user_id }}">Confirm Delete
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure want to delete supervisor
                                                "<strong>{{ $supervisor->user_name }}</strong>"?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
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

            <div class="mt-3">
                {{ $supervisors->links() }}
            </div>
        </div>
    </div>
@endsection
