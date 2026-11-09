{{-- resources/views/cities/modify.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $operation }} City</title>
    <script defer src="{{ asset('js/selecter.js') }}"></script>
</head>
<body>
    @php
        use Illuminate\Support\Facades\DB;

        $first = true;
        $selected_id = $data?->id_county;
        $is_unselected = is_null($selected_id);
        $counties = DB::table('counties')->get();
    @endphp

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
            <label for="zip_code">Zip Code</label><br>
            <input type="text" name="zip_code" id="zip_code" value="{{ $data?->zip_code ?? '' }}" maxlength="500" required>
        </p>
        
        <p>
            <label for="city">City</label><br>
            <input type="text" name="city" id="city" value="{{ $data?->city ?? '' }}" maxlength="500" required>
        </p>

        <p>
            <label for="population">Population</label><br>
            <input type="text" name="population" id="population" value="{{ $data?->population ?? '' }}" maxlength="500" required>
        </p>

        <p>
            <label for="id_county">County</label><br>
            <select id="selecter">
                @foreach ($counties as $county)
                @if ($first && $is_unselected)
                    <option value="{{ $county->id }}" selected>{{ $county->name }}</option>
                    @php($first = false)
                @elseif (!$is_unselected && $selected_id == $county->id)
                    <option value="{{ $county->id }}" selected>{{ $county->name }}</option>
                    @php($first = false)
                @else
                    <option value="{{ $county->id }}">{{ $county->name }}</option>
                @endif
                @endforeach
            </select>
            <input type="hidden" name="id_county" id="id_county" maxlength="50" required>
        </p>

        <button type="submit">Save</button>
    </form>

</body>
</html>