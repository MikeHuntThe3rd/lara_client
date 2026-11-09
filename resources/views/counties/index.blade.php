{{-- resources/views/counties/index.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Index Counties</title>
    <link rel="stylesheet" href="{{ asset('css/counties.css') }}">
</head>
<body>

    <h1>Counties</h1>
    <nav>
        <a href="{{ route('counties.create') }}">Add +</a>
        <a href="{{ route('cities.index') }}">Cities</a>
        <a href="/">Home</a>
    </nav>

    {{-- Kereső űrlap --}}
    <form action="{{ route('counties.index') }}" method="GET" class="search-form">
        <input type="text" name="search" placeholder="Search by name or badge..."
               value="{{ request('search') }}">
        <button type="submit">Search</button>
        @if(request('search'))
            <a href="{{ route('counties.index') }}">Clear</a>
        @endif
    </form>

    @php
        $stockCrest = 'data:image/svg+xml;utf8,'
            . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60">'
            . '<rect width="60" height="60" fill="#eee" stroke="#bbb" stroke-width="2"/>'
            . '<path d="M30 12 L46 20 V34 C46 42 38 48 30 50 C22 48 14 42 14 34 V20 Z" '
            . 'fill="#fff" stroke="#999" stroke-width="2"/>'
            . '<text x="30" y="57" font-size="7" text-anchor="middle" fill="#666">no crest</text>'
            . '</svg>');
    @endphp

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Badge</th>
                <th>Name</th>
                <th>Total Population</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($counties as $county)
                @php
                    $badge = trim((string) ($county->badge ?? ''));

                    $isValidBadge = $badge !== ''
                        && (str_starts_with($badge, 'http://')
                            || str_starts_with($badge, 'https://')
                            || str_starts_with($badge, '//'));
                @endphp
                <tr>
                    <td>{{ $county->id }}</td>
                    <td>
                        @if($isValidBadge)
                            <img src="{{ $badge }}"
                                 alt="{{ $county->name }} címere"
                                 class="coat-of-arms"
                                 loading="lazy"
                                 onerror="this.onerror=null; this.src='{{ $stockCrest }}'; this.classList.add('coat-of-arms--fallback');">
                        @else
                            <img src="{{ $stockCrest }}"
                                 alt="Nincs címer"
                                 class="coat-of-arms coat-of-arms--fallback">
                        @endif
                    </td>
                    <td>{{ $county->name }}</td>
                    <td>{{ number_format($county->total_population ?? 0, 0, ',', ' ') }}</td>
                    <td>
                        <form action="{{ route('counties.edit', $county->id) }}" method="GET" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-update">Update</button>
                        </form>
                        <form action="{{ route('counties.destroy', $county->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No counties found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html> 