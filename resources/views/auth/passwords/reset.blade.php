<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
</head>
<body>
    <h1>Reset Password</h1>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <!-- Hidden fields for the token and email -->
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <label for="password">New Password:</label><br>
        <input type="password" name="password" id="password" required><br><br>

        <label for="password_confirmation">Confirm New Password:</label><br>
        <input type="password" name="password_confirmation" id="password_confirmation" required><br><br>

        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
