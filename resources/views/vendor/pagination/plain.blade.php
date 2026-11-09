@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Pagination Navigation">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="pagination__item pagination__item--disabled">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination__item">&laquo;</a>
        @endif

        {{-- Page numbers --}}
        @foreach ($elements as $element)
            {{-- "Three dots" separator --}}
            @if (is_string($element))
                <span class="pagination__item pagination__item--disabled">{{ $element }}</span>
            @endif

            {{-- Array of links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="pagination__item pagination__item--active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pagination__item">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination__item">&raquo;</a>
        @else
            <span class="pagination__item pagination__item--disabled">&raquo;</span>
        @endif
    </nav>
@endif