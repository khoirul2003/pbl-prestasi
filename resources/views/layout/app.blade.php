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
        <style>
            .dashboard-card {
              border-radius: 1rem;
              box-shadow: 0 8px 20px rgba(0,0,0,0.12);
              transition: transform 0.3s ease, box-shadow 0.3s ease;
              cursor: default;
            }
            .dashboard-card:hover {
              transform: translateY(-8px);
              box-shadow: 0 16px 40px rgba(0,0,0,0.2);
            }
            .dashboard-card .card-body {
              display: flex;
              flex-direction: column;
              align-items: center;
              padding: 2.5rem 1.5rem;
              color: white;
            }
            .dashboard-card .card-title {
              font-weight: 700;
              font-size: 1.25rem;
              margin-bottom: 1.25rem;
              letter-spacing: 0.05em;
              text-transform: uppercase;
              text-shadow: 0 1px 3px rgba(0,0,0,0.3);
            }
            .dashboard-card .icon {
              font-size: 4.5rem;
              margin-bottom: 1rem;
              text-shadow: 0 2px 6px rgba(0,0,0,0.35);
            }
            .dashboard-card .count {
              font-size: 3rem;
              font-weight: 900;
              text-shadow: 0 3px 8px rgba(0,0,0,0.4);
            }
            /* Gradient backgrounds */
            .bg-primary-gradient {
              background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            }
            .bg-secondary-gradient {
              background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            }
            .bg-success-gradient {
              background: linear-gradient(135deg, #28a745 0%, #1c7430 100%);
            }
            .bg-info-gradient {
              background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
            }
          </style>
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
