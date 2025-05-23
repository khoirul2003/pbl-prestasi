<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>PRESen</title>
        {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
        <link rel="stylesheet" href="{{ asset('template/dist/assets/vendors/feather/feather.css') }}">
        <link rel="stylesheet" href="{{ asset('template/dist/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('template/dist/assets/vendors/ti-icons/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('template/dist/assets/vendors/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('template/dist/assets/vendors/typicons/typicons.css') }}">
        <link rel="stylesheet"
            href="{{ asset('template/dist/assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('template/dist/assets/vendors/css/vendor.bundle.base.css') }}">
        <link rel="stylesheet"
            href="{{ asset('template/dist/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('template/dist/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('template/dist/assets/js/select.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('template/dist/assets/css/style.css') }}">
        <link rel="shortcut icon" href="{{ asset('template/dist/assets/images/favicon.png') }}" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    </head>

    <body>

        <!-- Header -->
        @include('components.header')

        <div class="container-fluid page-body-wrapper">
            @include('components.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </div>
        </div>


        <!-- Footer -->
        @include('components.footer')


        @stack('scripts')
        <script src="{{ asset('template/dist/assets/vendors/js/vendor.bundle.base.js') }}"></script>
        <script src="{{ asset('template/dist/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('template/dist/assets/vendors/chart.js/chart.umd.js') }}"></script>
        <script src="{{ asset('template/dist/assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
        <script src="{{ asset('template/dist/assets/js/off-canvas.js') }}"></script>
        <script src="{{ asset('template/dist/assets/js/template.js') }}"></script>
        <script src="{{ asset('template/dist/assets/js/settings.js') }}"></script>
        <script src="{{ asset('template/dist/assets/js/hoverable-collapse.js') }}"></script>
        <script src="{{ asset('template/dist/assets/js/todolist.js') }}"></script>
        <script src="{{ asset('template/dist/assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
        <script src="{{ asset('template/dist/assets/js/dashboard.js') }}"></script>

    </body>

</html>
