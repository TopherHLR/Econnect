<style>
/* Make the Bootstrap classes act like horizontal Tailwind pagination */
.pagination, .pagination.mb-0 {
    display: flex !important;        /* horizontal layout */
    flex-wrap: wrap;                 /* allow wrapping on small screens */
    gap: 0.25rem;                    /* space between items */
    list-style: none;
    padding-left: 0;
    margin: 0;
}

.page-item {
    display: inline-block;           /* horizontal items */
}

.page-link {
    display: inline-block;
    padding: 0.375rem 0.75rem;
    border-radius: 0.375rem;
    border: 1px solid #E6EAD7;      /* match your table border color */
    background-color: #FFFFFF;       /* match your theme */
    color: #4F6B3F;
    text-decoration: none;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s;
}

.page-link:hover {
    background-color: #F0F7E6;      /* subtle hover */
}

.page-item.disabled .page-link {
    cursor: not-allowed;
    opacity: 0.5;
}

.page-item.active .page-link {
    background-color: #7F8A4F;      /* active bg */
    color: #FFFFFF;
    border-color: #7F8A4F;
}
</style>


{{-- Your pagination HTML --}}
@if ($paginator->hasPages())
<nav class="flex justify-between items-center flex-wrap mt-4">
    {{-- Showing results on the left --}}
    <div>
        <p class="text-sm text-[#6A8A52] mb-0">
            Showing
            @if ($paginator->firstItem())
                <span class="font-medium">{{ $paginator->firstItem() }}</span> to
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
            @else
                {{ $paginator->count() }}
            @endif
            of <span class="font-medium">{{ $paginator->total() }}</span> results
        </p>
    </div>

    {{-- Pagination numbers on the right --}}
    <div>
        <ul class="pagination mb-0 flex gap-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link cursor-not-allowed">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $paginator->previousPageUrl() }}" class="page-link ajax-page-link">&laquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link cursor-not-allowed">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $url }}" class="page-link ajax-page-link">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a href="{{ $paginator->nextPageUrl() }}" class="page-link ajax-page-link">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link cursor-not-allowed">&raquo;</span>
                </li>
            @endif
        </ul>
    </div>
</nav>
@endif


