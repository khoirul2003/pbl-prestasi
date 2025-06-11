<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <label for="email">Enter your email address</label>
        <input id="email" type="email" name="email" required>

        <button type="submit">Send Reset Link</button>
    </form>
    <a href="{{ route('login') }}">Back Login</a>
</body>
</html>
