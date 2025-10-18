@if ($paginator->hasPages())
    <ul class="Pagination">
        {{-- 前へ --}}
        @if ($paginator->onFirstPage())
            <li class="Pagination-Item">
                <span class="Pagination-Item-Link" aria-hidden="true">&lt;</span>
            </li>
        @else
            <li class="Pagination-Item">
                <a class="Pagination-Item-Link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lt;</a>
            </li>
        @endif

        {{-- ページ番号 --}}
        @foreach ($elements as $element)
            {{-- "三点リーダー" --}}
            @if (is_string($element))
                <li class="Pagination-Item disabled"><span class="Pagination-Item-Link">{{ $element }}</span></li>
            @endif

            {{-- 配列 --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="Pagination-Item active">
                            <span class="Pagination-Item-Link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="Pagination-Item">
                            <a class="Pagination-Item-Link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- 次へ --}}
        @if ($paginator->hasMorePages())
            <li class="Pagination-Item">
                <a class="Pagination-Item-Link" href="{{ $paginator->nextPageUrl() }}" rel="next">&gt;</a>
            </li>
        @else
            <li class="Pagination-Item">
                <span class="Pagination-Item-Link" aria-hidden="true">&gt;</span>
            </li>
        @endif
    </ul>
@endif
