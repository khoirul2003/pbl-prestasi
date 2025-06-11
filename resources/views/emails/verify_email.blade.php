<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
    <!-- Add Bootstrap CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styling for the email */
        body {
            background-color: #f4f4f4;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        footer {
            text-align: center;
            font-size: 14px;
            margin-top: 30px;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="email-container">
            <h1 class="text-center">Hello, {{ $user->user_name }}</h1>
            <p class="text-center">Thank you for registering! Please click the button below to verify your email address:</p>
            <div class="text-center">
                <a href="{{ $verificationUrl }}" class="btn btn-primary btn-lg">Verify Email</a>
            </div>
            <footer>
                <p>If you did not register, please ignore this email.</p>
            </footer>
        </div>
    </div>

    <!-- Add Bootstrap JS (optional, for additional features like modals) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
