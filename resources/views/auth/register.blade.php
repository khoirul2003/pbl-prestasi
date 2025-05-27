    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Register - Star Admin2</title>

        <!-- Stylesheets -->
        <link rel="stylesheet" href="{{ asset('template/dist/assets/vendors/feather/feather.css') }}">
        <link rel="stylesheet" href="{{ asset('template/dist/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('template/dist/assets/vendors/ti-icons/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('template/dist/assets/vendors/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('template/dist/assets/vendors/typicons/typicons.css') }}">
        <link rel="stylesheet" href="{{ asset('template/dist/assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('template/dist/assets/vendors/css/vendor.bundle.base.css') }}">
        <link rel="stylesheet" href="{{ asset('template/dist/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('template/dist/assets/css/style.css') }}">
        <link rel="shortcut icon" href="{{ asset('template/dist/assets/images/favicon.png') }}" />
    </head>
    <body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-6 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="{{ asset('template/dist/assets/images/logo.svg') }}" alt="logo" />
                            </div>
                            <h4>New here?</h4>
                            <h6 class="fw-light">Signing up is easy. It only takes a few steps</h6>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form class="pt-3" method="POST" action="{{ route('register.post') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="role" class="form-label">Register As</label>
                                    <select id="role" name="role" class="form-select" required onchange="showFields()">
                                        <option value="">Select Role</option>
                                        <option value="supervisor" {{ old('role') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="user_name" class="form-label">Name</label>
                                        <input type="text" id="user_name" name="user_name" value="{{ old('user_name') }}" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="user_username" class="form-label">Username</label>
                                        <input type="text" id="user_username" name="user_username" value="{{ old('user_username') }}" class="form-control" required>
                                    </div>
                                </div>

                                <!-- Supervisor fields -->
                                <div class="supervisor-fields d-none">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="detail_supervisor_nip" class="form-label">NIP</label>
                                            <input type="text" id="detail_supervisor_nip" name="detail_supervisor_nip" value="{{ old('detail_supervisor_nip') }}" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="department_id" class="form-label">Department</label>
                                            <select id="department_id" name="department_id" class="form-select" required>
                                                <option value="">Select Department</option>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->department_id }}" {{ old('department_id') == $department->department_id ? 'selected' : '' }}>
                                                        {{ $department->department_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="detail_supervisor_gender" class="form-label">Gender</label>
                                            <select id="detail_supervisor_gender" name="detail_supervisor_gender" class="form-select" required>
                                                <option value="">Select Gender</option>
                                                <option value="male" {{ old('detail_supervisor_gender') == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('detail_supervisor_gender') == 'female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="detail_supervisor_dob" class="form-label">Date of Birth</label>
                                            <input type="date" id="detail_supervisor_dob" name="detail_supervisor_dob" value="{{ old('detail_supervisor_dob') }}" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="detail_supervisor_email" class="form-label">Email</label>
                                            <input type="email" id="detail_supervisor_email" name="detail_supervisor_email" value="{{ old('detail_supervisor_email') }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="detail_supervisor_phone_no" class="form-label">Phone Number</label>
                                            <input type="text" id="detail_supervisor_phone_no" name="detail_supervisor_phone_no" value="{{ old('detail_supervisor_phone_no') }}" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-12 mb-3">
                                            <label for="detail_supervisor_address" class="form-label">Address</label>
                                            <input type="text" id="detail_supervisor_address" name="detail_supervisor_address" value="{{ old('detail_supervisor_address') }}" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Student fields -->
                                <div class="student-fields d-none">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="detail_student_nim" class="form-label">NIM</label>
                                            <input type="text" id="detail_student_nim" name="detail_student_nim" value="{{ old('detail_student_nim') }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="study_program_id" class="form-label">Study Program</label>
                                            <select id="study_program_id" name="study_program_id" class="form-select" required>
                                                <option value="">Select Study Program</option>
                                                @foreach($studyPrograms as $program)
                                                    <option value="{{ $program->study_program_id }}" {{ old('study_program_id') == $program->study_program_id ? 'selected' : '' }}>
                                                        {{ $program->study_program_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="detail_student_gender" class="form-label">Gender</label>
                                            <select id="detail_student_gender" name="detail_student_gender" class="form-select" required>
                                                <option value="">Select Gender</option>
                                                <option value="male" {{ old('detail_student_gender') == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('detail_student_gender') == 'female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="detail_student_dob" class="form-label">Date of Birth</label>
                                            <input type="date" id="detail_student_dob" name="detail_student_dob" value="{{ old('detail_student_dob') }}" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="detail_student_email" class="form-label">Email</label>
                                            <input type="email" id="detail_student_email" name="detail_student_email" value="{{ old('detail_student_email') }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="detail_student_phone_no" class="form-label">Phone Number</label>
                                            <input type="text" id="detail_student_phone_no" name="detail_student_phone_no" value="{{ old('detail_student_phone_no') }}" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-12 mb-3">
                                            <label for="detail_student_address" class="form-label">Address</label>
                                            <input type="text" id="detail_student_address" name="detail_student_address" value="{{ old('detail_student_address') }}" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="user_password" class="form-label">Password</label>
                                        <input type="password" id="user_password" name="user_password" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="user_password_confirmation" class="form-label">Confirm Password</label>
                                        <input type="password" id="user_password_confirmation" name="user_password_confirmation" class="form-control" required>
                                    </div>
                                </div>

                                <div class="mt-3 d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg fw-medium auth-form-btn">SIGN UP</button>
                                </div>

                                <div class="text-center mt-4 fw-light">
                                    Already have an account?
                                    <a href="{{ route('login') }}" class="text-primary">Login</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <script>
        function showFields() {
            const role = document.getElementById('role').value;
            document.querySelector('.supervisor-fields').classList.toggle('d-none', role !== 'supervisor');
            document.querySelector('.student-fields').classList.toggle('d-none', role !== 'student');
        }

        // On page load, show relevant fields if old input exists
        document.addEventListener('DOMContentLoaded', () => {
            showFields();
        });
    </script>

    <!-- Scripts -->
    <script src="{{ asset('template/dist/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('template/dist/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/template.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/settings.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('template/dist/assets/js/todolist.js') }}"></script>
    </body>
    </html>
