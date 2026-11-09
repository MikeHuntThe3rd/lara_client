<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf

        <label>Email
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </label>
        @error('email') <div>{{ $message }}</div> @enderror

        <label>Password
            <input type="password" name="password" required>
        </label>
        @error('password') <div>{{ $message }}</div> @enderror

        <button type="submit">Log in</button>
    </form>
</body>
</html>
