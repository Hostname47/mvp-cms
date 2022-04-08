@if($paginator->hasPages())
    <div class="align-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <div class="pagination-button pagination-button-disabled">
                <svg class="size8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M175.8,5.05c0,1,.86,1.29,1.38,1.82,10.06,10.1,20.1,20.21,30.25,30.21,1.62,1.61,1.91,2.39.09,4.19q-44.24,44-88.33,88.15,44.28,44.13,88.48,88.35c1.4,1.39,1.73,2.07.11,3.66-10.4,10.21-20.68,20.55-30.94,30.9-1.16,1.17-1.75,1.29-3,0Q113.19,191.6,52.41,131c-1.41-1.4-1-2,.13-3.18Q113,67.44,173.3,7c.57-.58,1.54-.93,1.53-2Z"/></svg>
            </div>
        @else
            <a class="pagination-button" href="{{ $paginator->previousPageUrl() }}">
                <svg class="size8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M175.8,5.05c0,1,.86,1.29,1.38,1.82,10.06,10.1,20.1,20.21,30.25,30.21,1.62,1.61,1.91,2.39.09,4.19q-44.24,44-88.33,88.15,44.28,44.13,88.48,88.35c1.4,1.39,1.73,2.07.11,3.66-10.4,10.21-20.68,20.55-30.94,30.9-1.16,1.17-1.75,1.29-3,0Q113.19,191.6,52.41,131c-1.41-1.4-1-2,.13-3.18Q113,67.44,173.3,7c.57-.58,1.54-.93,1.53-2Z"/></svg>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="pagination-separator">•••</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if($page == $paginator->currentPage())
                        <div class="pagination-button pagination-button-current-page">
                            <span>{{ $page }}</span>
                        </div>
                    @else
                        <a class="pagination-button" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="pagination-button" href="{{ $paginator->nextPageUrl() }}">
                <svg class="size8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M84.56,5.05c0,1-.85,1.29-1.38,1.82C73.12,17,63.08,27.08,52.94,37.08c-1.63,1.61-1.91,2.39-.1,4.19q44.23,44,88.34,88.15-44.29,44.13-88.49,88.35c-1.39,1.39-1.73,2.07-.11,3.66C63,231.64,73.26,242,83.52,252.33c1.16,1.17,1.75,1.29,3,0Q147.17,191.6,208,131c1.41-1.4,1-2-.13-3.18Q147.4,67.44,87.07,7c-.58-.58-1.54-.93-1.54-2Z"/></svg>
            </a>
        @else
            <div class="pagination-button pagination-button-disabled">
                <svg class="size8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M84.56,5.05c0,1-.85,1.29-1.38,1.82C73.12,17,63.08,27.08,52.94,37.08c-1.63,1.61-1.91,2.39-.1,4.19q44.23,44,88.34,88.15-44.29,44.13-88.49,88.35c-1.39,1.39-1.73,2.07-.11,3.66C63,231.64,73.26,242,83.52,252.33c1.16,1.17,1.75,1.29,3,0Q147.17,191.6,208,131c1.41-1.4,1-2-.13-3.18Q147.4,67.44,87.07,7c-.58-.58-1.54-.93-1.54-2Z"/></svg>
            </div>
        @endif
    </div>
@endif
