<!-- Modal Show User -->
<div class="modal fade" id="showUserModal{{ $user->user_id }}" tabindex="-1"
    aria-labelledby="showUserModalLabel{{ $user->user_id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showUserModalLabel{{ $user->user_id }}">User Details - {{ $user->user_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <!-- Left Column for Photo Preview -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Photo</label>
                        <div class="text-center">
                            <!-- If the photo exists, display it, otherwise show a placeholder image -->
                            <img id="photoPreview"
                                src="{{ asset(
                                    'photos/' .
                                        ($user->role->role_name == 'student' ? 'students' : 'supervisors') .
                                        '/' .
                                        (optional($user->role->role_name == 'student' ? $user->detailStudent : $user->detailSupervisor)->detail_student_photo ??
                                            (optional($user->role->role_name == 'student' ? $user->detailStudent : $user->detailSupervisor)->detail_supervisor_photo ??
                                                'default-photo.png')
                                        )
                                ) }}"
                                class="img-fluid rounded" style="max-width: 200px; max-height: 200px; object-fit: cover; display: block;" />
                        </div>
                    </div>

                    <!-- Right Column for User Info -->
                    <div class="col-md-8">
                        <!-- Common fields -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <p>{{ $user->user_name }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Username</label>
                                <p>{{ $user->user_username }}</p>
                            </div>
                        </div>

                        {{-- Student Fields --}}
                        @if (request('role') == 'student' || request('role') == null)
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <p>{{ $user->detailStudent->detail_student_email }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIM</label>
                                    <p>{{ $user->detailStudent->detail_student_nim }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Study Program</label>
                                    <p>{{ $user->detailStudent->studyProgram->study_program_name }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Gender</label>
                                    <p>{{ ucfirst($user->detailStudent->detail_student_gender) }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <p>{{ \Carbon\Carbon::parse($user->detailStudent->detail_student_dob)->format('d-m-Y') }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <p>{{ $user->detailStudent->detail_student_phone_no }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <p>{{ $user->detailStudent->detail_student_email }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Address</label>
                                    <p>{{ $user->detailStudent->detail_student_address }}</p>
                                </div>
                            </div>
                        @else
                            {{-- Supervisor Fields --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <p>{{ $user->detailSupervisor->detail_supervisor_email }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIP</label>
                                    <p>{{ $user->detailSupervisor->detail_supervisor_nip }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Department</label>
                                    <p>{{ $user->detailSupervisor->department->department_name }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Gender</label>
                                    <p>{{ ucfirst($user->detailSupervisor->detail_supervisor_gender) }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <p>{{ \Carbon\Carbon::parse($user->detailSupervisor->detail_supervisor_dob)->format('d-m-Y') }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <p>{{ $user->detailSupervisor->detail_supervisor_phone_no }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <p>{{ $user->detailSupervisor->detail_supervisor_email }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Address</label>
                                    <p>{{ $user->detailSupervisor->detail_supervisor_address }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
