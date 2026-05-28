@if ($paginator->hasPages())
    <div class="px-6 py-4 border-t border-surface-variant bg-surface-container-low/30 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <span class="font-label-md text-label-md text-on-surface-variant">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} entries
        </span>
        <div class="flex flex-wrap gap-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <button class="px-3 py-1 rounded text-on-surface-variant/50 font-label-md text-label-md cursor-not-allowed" disabled>Prev</button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 rounded text-on-surface-variant hover:bg-surface-container transition-colors font-label-md text-label-md">Prev</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-3 py-1 text-on-surface-variant">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-1 rounded bg-primary text-on-primary font-label-md text-label-md">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-1 rounded text-on-surface-variant hover:bg-surface-container transition-colors font-label-md text-label-md">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 rounded text-on-surface-variant hover:bg-surface-container transition-colors font-label-md text-label-md">Next</a>
            @else
                <button class="px-3 py-1 rounded text-on-surface-variant/50 font-label-md text-label-md cursor-not-allowed" disabled>Next</button>
            @endif
        </div>
    </div>
@endif
