<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Reset Request</title>

    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8; /* Light blue background */
            margin: 0;
            padding: 0;
            color: #333; /* Dark text for readability */
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff; /* White background for the content */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
        }

        h1 {
            color: #4A90E2; /* Light blue color for the header */
            text-align: center;
            margin-bottom: 20px;
            font-size: 26px;
        }

        p {
            line-height: 1.6;
            margin-bottom: 20px;
            font-size: 16px;
            color: #444; /* Slightly dark color for the text */
        }

        a {
            color: #121212;
            background-color: #4A90E2; /* Light blue background for the button */
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #357ABD; /* Darker blue when hovered */
        }

        .footer {
            font-size: 14px;
            text-align: center;
            color: #888; /* Gray color for the footer text */
            margin-top: 30px;
        }

        .footer a {
            color: #4A90E2; /* Light blue color for the footer links */
            text-decoration: none;
        }

        .footer a:hover {
            color: #357ABD; /* Darker blue for hover effect on footer link */
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Password Reset Request</h1>
        <p>You are receiving this email because we received a password reset request for your account.</p>

        <p><a href="{{ $resetUrl }}" target="_blank">Click here to reset your password</a></p>

        <p>If you did not request a password reset, no further action is required.</p>

        <p class="footer">
            &copy; {{ date('Y') }} Present. All Rights Reserved.
        </p>
    </div>

</body>

</html>
