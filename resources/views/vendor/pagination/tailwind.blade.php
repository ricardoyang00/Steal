@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="pagination-nav">
        <div class="pagination-links">
            @if ($paginator->onFirstPage())
                <span class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">Prev</span>
                </span>
            @else
                <a class="page-item" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                    <span class="page-link">Prev</span>
                </a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></span>
                        @elseif ($page == 1 || $page == $paginator->lastPage() || ($page >= $paginator->currentPage() - 4 && $page <= $paginator->currentPage() + 4))
                            <a class="page-item" href="{{ $url }}"><span class="page-link">{{ $page }}</span></a>
                        @elseif ($page == $paginator->currentPage() - 5 || $page == $paginator->currentPage() + 5)
                            <span class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></span>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a class="page-item" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                    <span class="page-link">Next</span>
                </a>
            @else
                <span class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">Next</span>
                </span>
            @endif
        </div>
    </nav>
@endif