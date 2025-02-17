 @if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">&lt;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lt;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&gt;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">&gt;</span>
                </li>
            @endif
        </ul>
    </nav>

    <style>
    .pagination {
        display: flex;
        align-items: center;
        gap: 4px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .pagination .page-item {
        margin: 0;
    }

    .pagination .page-link {
        padding: 8px 12px;
        color: #000;
        text-decoration: none;
        background: none;
        border: none;
        font-size: 14px;
    }

    .pagination .page-item:not(:last-child) .page-link::after {
        content: ".";
        margin-left: 8px;
        color: #000;
    }

    .pagination .page-item.active .page-link {
        color: #0000ff;
        font-weight: bold;
    }

    .pagination .page-item.disabled .page-link {
        color: #666;
        pointer-events: none;
    }

    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        font-size: 40px !important;
        color: #6b21a8;
        padding: 0 !important;
        line-height: 0.5;
        font-weight: bold;
        margin: 0 10px;
    }

    .pagination .page-item:first-child .page-link {
        transform: scaleX(0.5);
    }

    .pagination .page-item:last-child .page-link {
        transform: scaleX(0.5);
    }
    </style>
@endif
