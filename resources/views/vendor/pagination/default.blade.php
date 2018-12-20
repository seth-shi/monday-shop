@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span class="page-number previous">上一页</span></li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-number previous">上一页</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span class="page-number">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><span class="page-number current">{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}" class="page-number">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page-numbers next">下一页</a>
            </li>
        @else
            <li class="disabled"><span class="page-numbers next ">下一页</span></li>
        @endif
    </ul>
@endif
