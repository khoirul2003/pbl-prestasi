@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Student Data</h4>

        <!-- Button Add Student -->
        <button type="button" class="btn btn-primary btn-rounded btn-fw mb-2" data-bs-toggle="modal" data-bs-target="#addStudentModal">
            Add Student
        </button>

        <!-- Modal Add Student -->
        <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addStudentLabel">Add Student</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="user_name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="user_name" name="user_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="user_username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="user_username" name="user_username" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="user_password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="user_password" name="user_password" required
                                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}$"
                                        title="Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan simbol seperti @$!%*#?&">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="user_password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="user_password_confirmation" name="user_password_confirmation" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="study_program_id" class="form-label">Study Program</label>
                                <select name="study_program_id" id="study_program_id" class="form-select" required>
                                    <option value="" disabled selected>Select Study Program</option>
                                    @foreach(\App\Models\StudyProgram::all() as $program)
                                        <option value="{{ $program->study_program_id }}">{{ $program->study_program_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="detail_student_nim" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="detail_student_nim" name="detail_student_nim" required>
                            </div>

                            <div class="mb-3">
                                <label for="detail_student_gender" class="form-label">Gender</label>
                                <select name="detail_student_gender" id="detail_student_gender" class="form-select" required>
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="detail_student_dob" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="detail_student_dob" name="detail_student_dob" required>
                            </div>

                            <div class="mb-3">
                                <label for="detail_student_address" class="form-label">Address</label>
                                <textarea class="form-control" id="detail_student_address" name="detail_student_address" rows="2" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="detail_student_phone_no" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="detail_student_phone_no" name="detail_student_phone_no" required>
                            </div>

                            <div class="mb-3">
                                <label for="detail_student_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="detail_student_email" name="detail_student_email" required>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Student</button>
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
                        <th>NIM</th>
                        <th>Study Program</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                    <tr>
                        <td>{{ $students->firstItem() + $loop->index }}</td>
                        <td>{{ $student->user_name }}</td>
                        <td>{{ $student->user_username }}</td>
                        <td>{{ $student->detailStudent->detail_student_nim ?? '-' }}</td>
                        <td>{{ $student->detailStudent->studyProgram->study_program_name ?? '-' }}</td>
                        <td>{{ ucfirst($student->detailStudent->detail_student_gender ?? '-') }}</td>
                        <td>{{ $student->detailStudent->detail_student_email ?? '-' }}</td>
                        <td>{{ $student->detailStudent->detail_student_phone_no ?? '-' }}</td>
                        <td>
                            <!-- Show -->
                            <button type="button" class="btn btn-info btn-rounded btn-fw text-white" data-bs-toggle="modal" data-bs-target="#showStudentModal{{ $student->user_id }}">
                                Show
                            </button>
                            <!-- Edit -->
                            <button type="button" class="btn btn-warning btn-rounded btn-fw text-white" data-bs-toggle="modal" data-bs-target="#editStudentModal{{ $student->user_id }}">
                                Edit
                            </button>
                            <!-- Delete -->
                            <button type="button" class="btn btn-danger btn-rounded btn-fw" data-bs-toggle="modal" data-bs-target="#deleteStudentModal{{ $student->user_id }}">
                                Delete
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Show Student -->
                    <div class="modal fade" id="showStudentModal{{ $student->user_id }}" tabindex="-1" aria-labelledby="showStudentLabel{{ $student->user_id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showStudentLabel{{ $student->user_id }}">Student Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            @if($student->detailStudent->detail_student_photo)
                                            <img src="{{ asset('photos/students/' . $student->detailStudent->detail_student_photo) }}" alt="Photo" class="img-fluid rounded shadow-sm mb-3" style="max-height: 250px; object-fit: cover;">
                                            @else
                                            <div class="border rounded d-flex align-items-center justify-content-center mb-3" style="height: 250px; background-color: #f8f9fa; color: #6c757d;">
                                                No Photo
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-md-8">
                                            <dl class="row">
                                                <dt class="col-sm-4">Name</dt>
                                                <dd class="col-sm-8">{{ $student->user_name }}</dd>

                                                <dt class="col-sm-4">Username</dt>
                                                <dd class="col-sm-8">{{ $student->user_username }}</dd>

                                                <dt class="col-sm-4">NIM</dt>
                                                <dd class="col-sm-8">{{ $student->detailStudent->detail_student_nim ?? '-' }}</dd>

                                                <dt class="col-sm-4">Study Program</dt>
                                                <dd class="col-sm-8">{{ $student->detailStudent->studyProgram->study_program_name ?? '-' }}</dd>

                                                <dt class="col-sm-4">Gender</dt>
                                                <dd class="col-sm-8">{{ ucfirst($student->detailStudent->detail_student_gender ?? '-') }}</dd>

                                                <dt class="col-sm-4">Date of Birth</dt>
                                                <dd class="col-sm-8">{{ $student->detailStudent->detail_student_dob ?? '-' }}</dd>

                                                <dt class="col-sm-4">Address</dt>
                                                <dd class="col-sm-8">{{ $student->detailStudent->detail_student_address ?? '-' }}</dd>

                                                <dt class="col-sm-4">Phone</dt>
                                                <dd class="col-sm-8">{{ $student->detailStudent->detail_student_phone_no ?? '-' }}</dd>

                                                <dt class="col-sm-4">Email</dt>
                                                <dd class="col-sm-8">{{ $student->detailStudent->detail_student_email ?? '-' }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit Student -->
                    <div class="modal fade" id="editStudentModal{{ $student->user_id }}" tabindex="-1" aria-labelledby="editStudentLabel{{ $student->user_id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form action="{{ route('students.update', $student->user_id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editStudentLabel{{ $student->user_id }}">Edit Student</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="user_name_{{ $student->user_id }}" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="user_name_{{ $student->user_id }}" name="user_name" value="{{ $student->user_name }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="user_username_{{ $student->user_id }}" class="form-label">Username</label>
                                                <input type="text" class="form-control" id="user_username_{{ $student->user_id }}" name="user_username" value="{{ $student->user_username }}" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="user_password_{{ $student->user_id }}" class="form-label">Password (leave blank to keep current)</label>
                                                <input type="password" class="form-control" id="user_password_{{ $student->user_id }}" name="user_password"
                                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}$"
                                                    title="Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan simbol seperti @$!%*#?&">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="user_password_confirmation_{{ $student->user_id }}" class="form-label">Confirm Password</label>
                                                <input type="password" class="form-control" id="user_password_confirmation_{{ $student->user_id }}" name="user_password_confirmation">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="study_program_id_{{ $student->user_id }}" class="form-label">Study Program</label>
                                            <select name="study_program_id" id="study_program_id_{{ $student->user_id }}" class="form-select" required>
                                                <option value="" disabled>Select Study Program</option>
                                                @foreach(\App\Models\StudyProgram::all() as $program)
                                                    <option value="{{ $program->study_program_id }}" @if(($student->detailStudent->study_program_id ?? '') == $program->study_program_id) selected @endif>
                                                        {{ $program->study_program_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="detail_student_nim_{{ $student->user_id }}" class="form-label">NIM</label>
                                            <input type="text" class="form-control" id="detail_student_nim_{{ $student->user_id }}" name="detail_student_nim" value="{{ $student->detailStudent->detail_student_nim ?? '' }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="detail_student_gender_{{ $student->user_id }}" class="form-label">Gender</label>
                                            <select name="detail_student_gender" id="detail_student_gender_{{ $student->user_id }}" class="form-select" required>
                                                <option value="male" @if(($student->detailStudent->detail_student_gender ?? '') == 'male') selected @endif>Male</option>
                                                <option value="female" @if(($student->detailStudent->detail_student_gender ?? '') == 'female') selected @endif>Female</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="detail_student_dob_{{ $student->user_id }}" class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control" id="detail_student_dob_{{ $student->user_id }}" name="detail_student_dob" value="{{ $student->detailStudent->detail_student_dob ?? '' }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="detail_student_address_{{ $student->user_id }}" class="form-label">Address</label>
                                            <textarea class="form-control" id="detail_student_address_{{ $student->user_id }}" name="detail_student_address" rows="2" required>{{ $student->detailStudent->detail_student_address ?? '' }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="detail_student_phone_no_{{ $student->user_id }}" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" id="detail_student_phone_no_{{ $student->user_id }}" name="detail_student_phone_no" value="{{ $student->detailStudent->detail_student_phone_no ?? '' }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="detail_student_email_{{ $student->user_id }}" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="detail_student_email_{{ $student->user_id }}" name="detail_student_email" value="{{ $student->detailStudent->detail_student_email ?? '' }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="detail_student_photo_{{ $student->user_id }}" class="form-label">Photo</label>
                                            <input type="file" class="form-control" id="detail_student_photo_{{ $student->user_id }}" name="detail_student_photo" accept="image/*">
                                            @if($student->detailStudent->detail_student_photo)
                                            <img src="{{ asset('photos/students/' . $student->detailStudent->detail_student_photo) }}" alt="Photo" class="img-fluid mt-2" style="max-width: 150px;">
                                            @endif
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-warning">Update Student</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Delete Student -->
                    <div class="modal fade" id="deleteStudentModal{{ $student->user_id }}" tabindex="-1" aria-labelledby="deleteStudentLabel{{ $student->user_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('students.destroy', $student->user_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteStudentLabel{{ $student->user_id }}">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure want to delete student "<strong>{{ $student->user_name }}</strong>"?
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

        <div class="mt-3">
            {{ $students->links() }}
        </div>
    </div>
</div>
@endsection
