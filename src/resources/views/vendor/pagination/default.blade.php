@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled" aria-disabled="true"><span>@lang('pagination.previous')</span></li>
        @else
            <li><a href="{{ \App\Helpers\UrlHelper::generateUrl($paginator->previousPageUrl()) }}" rel="prev">@lang('pagination.previous')</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ \App\Helpers\UrlHelper::generateUrl($url) }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ \App\Helpers\UrlHelper::generateUrl($paginator->nextPageUrl()) }}" rel="next">@lang('pagination.next')</a></li>
        @else
            <li class="disabled" aria-disabled="true"><span>@lang('pagination.next')</span></li>
        @endif
    </ul>
@endif
