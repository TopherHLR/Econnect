<div id="paginationLinks">
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between mt-4">
        <div class="flex justify-between flex-1 sm:hidden">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 text-sm font-medium text-gray-400 bg-[#F5F7F0] border border-[#E6EAD7] rounded-md cursor-default">
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="px-4 py-2 text-sm font-medium text-[#4F6B3F] bg-white border border-[#E6EAD7] rounded-md hover:bg-[#F0F7E6] transition ajax-page-link">
                    Previous
                </a>
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="px-4 py-2 ml-3 text-sm font-medium text-[#4F6B3F] bg-white border border-[#E6EAD7] rounded-md hover:bg-[#F0F7E6] transition ajax-page-link">
                    Next
                </a>
            @else
                <span class="px-4 py-2 ml-3 text-sm font-medium text-gray-400 bg-[#F5F7F0] border border-[#E6EAD7] rounded-md cursor-default">
                    Next
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            {{-- Info --}}
            <p class="text-sm text-[#6A8A52]">
                Showing
                @if ($paginator->firstItem())
                    <span class="font-medium">{{ $paginator->firstItem() }}</span> to
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                of <span class="font-medium">{{ $paginator->total() }}</span> results
            </p>

            {{-- Page Links --}}
            <span class="inline-flex rounded-md shadow-sm">

                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true"
                          class="px-3 py-2 text-sm font-medium text-gray-400 bg-[#F5F7F0] border border-[#E6EAD7] rounded-l-md cursor-default">
                        &laquo;
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}"
                       class="px-3 py-2 text-sm font-medium text-[#4F6B3F] bg-white border border-[#E6EAD7] rounded-l-md hover:bg-[#F0F7E6] transition ajax-page-link">
                        &laquo;
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="px-3 py-2 text-sm font-medium text-gray-400 bg-[#F5F7F0] border-t border-b border-[#E6EAD7] cursor-default">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page"
                                      class="px-3 py-2 text-sm font-medium text-white bg-[#7F8A4F] border border-[#E6EAD7]">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                   class="px-3 py-2 text-sm font-medium text-[#4F6B3F] bg-white border border-[#E6EAD7] hover:bg-[#F0F7E6] transition ajax-page-link">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <a class="ajax-page-link" href="{{ $paginator->nextPageUrl() }}"
                       class="px-3 py-2 text-sm font-medium text-[#4F6B3F] bg-white border border-[#E6EAD7] rounded-r-md hover:bg-[#F0F7E6] transition ajax-page-link">
                        &raquo;
                    </a>
                @else
                    <span aria-disabled="true"
                          class="px-3 py-2 text-sm font-medium text-gray-400 bg-[#F5F7F0] border border-[#E6EAD7] rounded-r-md cursor-default">
                        &raquo;
                    </span>
                @endif

            </span>
        </div>
    </nav>
@endif
</div>
