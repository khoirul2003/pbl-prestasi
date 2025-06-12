<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Reset - PRESen</title>

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
    <link rel="shortcut icon" href="{{ asset('template/pngwing.com.png') }}" />
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0 justify-content-center">
                    <div class="col-lg-6 col-md-8 col-sm-8 col-11 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5 rounded shadow-sm">
                            <div class="mb-3">
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                                    ← Back to Login
                                </a>
                            </div>
                            <div class="brand-logo text-center">
                                <img src="{{ asset('template/logo.png') }}" alt="logo" />
                            </div>

                            <h4 class="text-center mb-1">Reset Your Password</h4>
                            <h6 class="fw-light text-center mb-4">Enter your new password below.</h6>

                            @if(session('status'))
                                <div class="alert alert-success">{{ session('status') }}</div>
                            @endif

                            <form class="pt-2" method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}"
                                           class="form-control form-control-lg @error('email') is-invalid @enderror" required>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input id="password" type="password" name="password"
                                           class="form-control form-control-lg @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation"
                                           class="form-control form-control-lg" required>
                                </div>

                                <div class="d-grid gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary btn-lg fw-medium auth-form-btn">
                                        Reset Password
                                    </button>
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
