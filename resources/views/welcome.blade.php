<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>laravel postoffice</title>
</head>
<body>
    <h3>Laravel Postoffice</h3>
    <nav>
        <a href="{{ route('counties.index') }}">counties</a>
        <a href="{{ route('cities.index') }}">cities</a>
        <a href="{{ route('login') }}">login</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">logout</button>
        </form>
    </nav>
</body>
</html>