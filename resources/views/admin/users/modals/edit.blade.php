<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal{{ $user->user_id }}" tabindex="-1" aria-labelledby="editUserLabel{{ $user->user_id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('admin.users.update', ['role' => request('role'), 'id' => $user->user_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserLabel{{ $user->user_id }}">Edit {{ ucfirst(request('role') ?? 'student') }} - {{ $user->user_name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!-- Left Column for Photo Preview -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Photo Preview</label>
                            <div class="text-center">
                                <!-- If the photo exists, display it, otherwise show a placeholder image -->
                                <img id="photoPreview"
                                     src="{{ asset('photos/' . ($user->role->role_name == 'student' ? 'students' : 'supervisors') . '/' .
                                            (optional($user->role->role_name == 'student' ? $user->detailStudent : $user->detailSupervisor)->detail_student_photo ??
                                            optional($user->role->role_name == 'student' ? $user->detailStudent : $user->detailSupervisor)->detail_supervisor_photo
                                            ?? 'default-photo.png')) }}"
                                     class="img-fluid rounded" style="max-width: 100%; height: auto; display: block;" />
                            </div>

                            <div class="text-center mt-2">
                                <!-- Input for uploading a new photo -->
                                <input type="file" class="form-control"
                                       name="{{ $user->role->role_name == 'student' ? 'detail_student_photo' : 'detail_supervisor_photo' }}"
                                       accept="image/*" onchange="previewPhoto(event)">
                            </div>
                        </div>

                        <!-- Right Column for Form Fields -->
                        <div class="col-md-8">
                            <!-- Common fields -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="user_name" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="user_name" placeholder="Full Name" value="{{ $user->user_name }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="user_username" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="user_username" placeholder="Username" value="{{ $user->user_username }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="user_password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="user_password" placeholder="Password (Leave empty if not changing)">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="user_password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="user_password_confirmation" placeholder="Confirm Password (Leave empty if not changing)">
                                </div>
                            </div>

                            {{-- Student fields --}}
                            @if(request('role') == 'student' || request('role') == null)
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="detail_student_nim" class="form-label">NIM</label>
                                        <input type="text" class="form-control" name="detail_student_nim" value="{{ $user->detailStudent->detail_student_nim }}" placeholder="Student NIM" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="study_program_id" class="form-label">Study Program</label>
                                        <select class="form-select" name="study_program_id" required>
                                            @foreach(\App\Models\StudyProgram::all() as $program)
                                                <option value="{{ $program->study_program_id }}" {{ $user->detailStudent->study_program_id == $program->study_program_id ? 'selected' : '' }}>{{ $program->study_program_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Gender</label><br>
                                        <label><input type="radio" name="detail_student_gender" value="male" {{ $user->detailStudent->detail_student_gender == 'male' ? 'checked' : '' }} required> Male</label>
                                        <label class="ms-3"><input type="radio" name="detail_student_gender" value="female" {{ $user->detailStudent->detail_student_gender == 'female' ? 'checked' : '' }} required> Female</label>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="detail_student_dob" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" name="detail_student_dob" value="{{ $user->detailStudent->detail_student_dob }}" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="detail_student_phone_no" class="form-label">Phone</label>
                                        <input type="text" class="form-control" name="detail_student_phone_no" value="{{ $user->detailStudent->detail_student_phone_no }}" placeholder="Phone Number" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="detail_student_email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="detail_student_email" value="{{ $user->detailStudent->detail_student_email }}" placeholder="Email Address" required>
                                    </div>
                                </div>

                                <!-- Address moved to the bottom -->
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="detail_student_address" class="form-label">Address</label>
                                        <textarea class="form-control" name="detail_student_address" placeholder="Full Address" rows="3" required>{{ $user->detailStudent->detail_student_address }}</textarea>
                                    </div>
                                </div>
                            @else
                            {{-- Supervisor fields --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="detail_supervisor_nip" class="form-label">NIP</label>
                                        <input type="text" class="form-control" name="detail_supervisor_nip" value="{{ $user->detailSupervisor->detail_supervisor_nip }}" placeholder="Supervisor NIP" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="department_id" class="form-label">Department</label>
                                        <select class="form-select" name="department_id" required>
                                            @foreach(\App\Models\Department::all() as $dept)
                                                <option value="{{ $dept->department_id }}" {{ $user->detailSupervisor->department_id == $dept->department_id ? 'selected' : '' }}>{{ $dept->department_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Gender</label><br>
                                        <label><input type="radio" name="detail_supervisor_gender" value="male" {{ $user->detailSupervisor->detail_supervisor_gender == 'male' ? 'checked' : '' }} required> Male</label>
                                        <label class="ms-3"><input type="radio" name="detail_supervisor_gender" value="female" {{ $user->detailSupervisor->detail_supervisor_gender == 'female' ? 'checked' : '' }} required> Female</label>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="detail_supervisor_dob" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" name="detail_supervisor_dob" value="{{ $user->detailSupervisor->detail_supervisor_dob }}" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="detail_supervisor_phone_no" class="form-label">Phone</label>
                                        <input type="text" class="form-control" name="detail_supervisor_phone_no" value="{{ $user->detailSupervisor->detail_supervisor_phone_no }}" placeholder="Phone Number" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="detail_supervisor_email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="detail_supervisor_email" value="{{ $user->detailSupervisor->detail_supervisor_email }}" placeholder="Email Address" required>
                                    </div>
                                </div>

                                <!-- Address moved to the bottom -->
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="detail_supervisor_address" class="form-label">Address</label>
                                        <textarea class="form-control custom-textarea" name="detail_supervisor_address" placeholder="Full Address" required>{{ $user->detailSupervisor->detail_supervisor_address }}</textarea>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .custom-textarea {
        height: 200px; /* Adjust the height to your preference */
        width: 100%; /* Adjust the width to your preference */
    }
</style>

<script>
    // Preview the image when user selects a file
    function previewPhoto(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('photoPreview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
