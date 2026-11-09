{{-- resources/views/counties/modify.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $operation }} County</title>
</head>
<body>

    <h1>{{ $operation }} County</h1>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ $action }}" method="POST">
        @csrf
        @method($method)

        <p>
            <label for="badge">Badge</label><br>
            <input type="text" name="badge" id="badge" value="{{ $data?->badge ?? '' }}" maxlength="500" required>
        </p>

        <p>
            <label for="name">Name</label><br>
            <input type="text" name="name" id="name" value="{{ $data?->name ?? '' }}" maxlength="50" required>
        </p>

        <button type="submit">Save</button>
    </form>

</body>
</html>