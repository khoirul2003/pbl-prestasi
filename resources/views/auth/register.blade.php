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
            <link rel="stylesheet"
                href="{{ asset('template/dist/assets/vendors/font-awesome/css/font-awesome.min.css') }}">
            <link rel="stylesheet" href="{{ asset('template/dist/assets/vendors/typicons/typicons.css') }}">
            <link rel="stylesheet"
                href="{{ asset('template/dist/assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
            <link rel="stylesheet" href="{{ asset('template/dist/assets/vendors/css/vendor.bundle.base.css') }}">
            <link rel="stylesheet"
                href="{{ asset('template/dist/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
            <link rel="stylesheet" href="{{ asset('template/dist/assets/css/style.css') }}">
            <link rel="shortcut icon" href="{{ asset('template/dist/assets/images/favicon.png') }}" />
        </head>

        <body>
            <div class="container-scroller">
                <div class="container-fluid page-body-wrapper full-page-wrapper">
                    <div class="content-wrapper d-flex align-items-center auth px-0">
                        <div class="row w-100 mx-0">
                            <div class="col-lg-8 mx-auto">
                                <div class="auth-form-light text-left py-5 px-4 px-sm-5 shadow rounded">
                                    <div class="mb-3">
                                        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm">
                                            ← Back to Home
                                        </a>
                                    </div>
                                    <div class="brand-logo text-center">
                                        <img src="{{ asset('template/logo.png') }}" alt="logo" />
                                    </div>
                                    <h4 class="text-center">Register New Account</h4>
                                    <p class="fw-light text-center mb-4">Fill in the details below to create your student account.</p>

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('register.post') }}">
                                        @csrf
                                        <input type="hidden" name="role" value="student" />

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="user_name" class="form-label">Full Name</label>
                                                <input type="text" class="form-control" id="user_name" name="user_name" value="{{ old('user_name') }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="user_username" class="form-label">Username</label>
                                                <input type="text" class="form-control" id="user_username" name="user_username" value="{{ old('user_username') }}" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="detail_student_nim" class="form-label">NIM</label>
                                                <input type="text" class="form-control" id="detail_student_nim" name="detail_student_nim" value="{{ old('detail_student_nim') }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="study_program_id" class="form-label">Study Program</label>
                                                <select class="form-select" id="study_program_id" name="study_program_id" required>
                                                    <option value="">-- Select Program --</option>
                                                    @foreach ($studyPrograms as $program)
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
                                                <select class="form-select" id="detail_student_gender" name="detail_student_gender" required>
                                                    <option value="">-- Select Gender --</option>
                                                    <option value="male" {{ old('detail_student_gender') == 'male' ? 'selected' : '' }}>Male</option>
                                                    <option value="female" {{ old('detail_student_gender') == 'female' ? 'selected' : '' }}>Female</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="detail_student_dob" class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control" id="detail_student_dob" name="detail_student_dob" value="{{ old('detail_student_dob') }}" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="detail_student_email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="detail_student_email" name="detail_student_email" value="{{ old('detail_student_email') }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="detail_student_phone_no" class="form-label">Phone Number</label>
                                                <input type="text" class="form-control" id="detail_student_phone_no" name="detail_student_phone_no" value="{{ old('detail_student_phone_no') }}" required>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="detail_student_address" class="form-label">Address</label>
                                            <input type="text" class="form-control" id="detail_student_address" name="detail_student_address" value="{{ old('detail_student_address') }}" required>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="user_password" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="user_password" name="user_password" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="user_password_confirmation" class="form-label">Confirm Password</label>
                                                <input type="password" class="form-control" id="user_password_confirmation" name="user_password_confirmation" required>
                                            </div>
                                        </div>

                                        <div class="d-grid mt-4">
                                            <button type="submit" class="btn btn-primary btn-lg">Register</button>
                                        </div>

                                        <div class="text-center mt-3">
                                            <small class="text-muted">Already have an account? <a href="{{ route('login') }}" class="text-primary">Login here</a></small>
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
