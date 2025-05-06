<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name', 'Sistem Pencatatan Prestasi') }}</title>
        <!-- Include Bootstrap (Opsional) -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
        /* Add this style to ensure the footer stays at the bottom */
        html, body {
            height: 100%;
        }

        .container-fluid {
            flex: 1;
        }

        .footer {
            margin-top: auto;
        }
    </style>
    </head>

    <body class="d-flex flex-column">

        <!-- Navbar -->
        <x-navbar />

        <div class="container-fluid mt-4">
            <div class="row">
                <!-- Sidebar -->
                <x-sidebar />

                <!-- Content -->
                <div class="col-md-10">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Footer -->
        <x-footer />

        <!-- Include JS and Bootstrap -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>

</html>
