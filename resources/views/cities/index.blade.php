{{-- resources/views/cities/index.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Index Cities</title>
    <link rel="stylesheet" href="{{ asset('css/cities.css') }}">
</head>
<body>

    <h1>Cities</h1>
    <nav>
        <a href="{{ route('cities.create') }}">Add +</a>
        <a href="{{ route('counties.index') }}">Counties</a>
        <a href="/">Home</a>
    </nav>

    {{-- Kereső + megye szűrő űrlap --}}
    <form action="{{ route('cities.index') }}" method="GET" class="filter-form">
        <input type="text" name="search" placeholder="Search by city or zip code..."
               value="{{ request('search') }}">

        <select name="county_id">
            <option value="">All Counties</option>
            @foreach ($counties as $county)
                <option value="{{ $county->id }}"
                    {{ request('county_id') == $county->id ? 'selected' : '' }}>
                    {{ $county->name }}
                </option>
            @endforeach
        </select>

        <button type="submit">Filter</button>
        @if(request('search') || request('county_id'))
            <a href="{{ route('cities.index') }}">Clear</a>
        @endif
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Zip Code</th>
                <th>City</th>
                <th>Population</th>
                <th>County</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cities as $city)
                <tr>
                    <td>{{ $city->id }}</td>
                    <td>{{ $city->zip_code }}</td>
                    <td>{{ $city->city }}</td>
                    <td>{{ number_format($city->population, 0, ',', ' ') }}</td>
                    <td>{{ $city->county_name ?? '—' }}</td>
                    <td>
                        <form action="{{ route('cities.edit', $city->id) }}" method="GET" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-update">Update</button>
                        </form>
                        <form action="{{ route('cities.destroy', $city->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No cities found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Lapozó --}}
    <div class="pagination-wrapper">
        {{ $cities->links('vendor.pagination.plain') }}
    </div>

</body>
</html>