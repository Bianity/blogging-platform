@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}"
        class="flex items-center justify-between">
        <div class="flex flex-1 justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span
                    class="border-primary-200 dark:border-primary-900 relative inline-flex cursor-default items-center rounded-md border bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-500 dark:bg-slate-800 dark:text-slate-200">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="border-primary-200 dark:border-primary-900 dark:bg-primary-500 bg-primary-500 relative inline-flex items-center rounded-md border px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out hover:text-gray-500 focus:border-blue-300 focus:outline-none active:bg-gray-100 active:text-gray-700 dark:text-slate-200">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="border-primary-200 dark:border-primary-900 dark:bg-primary-500 bg-primary-500 relative ml-3 inline-flex items-center rounded-md border px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out hover:text-gray-500 focus:border-blue-300 focus:outline-none active:bg-gray-100 active:text-gray-700 dark:text-slate-200">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span
                    class="border-primary-200 dark:border-primary-900 relative ml-3 inline-flex cursor-default items-center rounded-md border bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-500 dark:bg-slate-800 dark:text-slate-200">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm leading-5 text-gray-700 dark:text-slate-200">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rounded-md shadow-sm">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span
                                class="border-primary-200 hover:bg-primary-100 dark:border-primary-900 relative inline-flex cursor-default items-center rounded-l-md border bg-white px-2 py-2 text-sm font-medium leading-5 text-gray-500 dark:bg-slate-800"
                                aria-hidden="true">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                            class="border-primary-200 hover:bg-primary-100 hover:text-primary-500 focus:border-primary-300 dark:border-primary-900 relative inline-flex items-center rounded-l-md border bg-white px-2 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out focus:z-10 focus:outline-none active:bg-gray-100 active:text-gray-500 dark:bg-slate-800 dark:text-slate-200"
                            aria-label="{{ __('pagination.previous') }}">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span
                                    class="border-primary-200 dark:border-primary-900 relative -ml-px inline-flex cursor-default items-center border bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-500">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span
                                            class="bg-primary-500 border-primary-200 dark:border-primary-900 dark:text-primary-500 dark:bg-primary-900 relative -ml-px inline-flex cursor-default items-center border px-4 py-2 text-sm font-medium leading-5 text-white">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="hover:bg-primary-100 border-primary-200 hover:text-primary-500 dark:border-primary-900 active:bg-primary-100 active:text-primary-700 relative -ml-px inline-flex items-center border bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out focus:z-10 focus:border-blue-300 focus:outline-none dark:bg-slate-800 dark:text-slate-200"
                                        aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                            class="hover:bg-primary-100 border-primary-200 hover:text-primary-500 dark:border-primary-900 active:bg-primary-100 active:text-primary-500 relative -ml-px inline-flex items-center rounded-r-md border bg-white px-2 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out focus:z-10 focus:border-blue-300 focus:outline-none dark:bg-slate-800 dark:text-slate-200"
                            aria-label="{{ __('pagination.next') }}">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span
                                class="hover:bg-primary-100 border-primary-200 dark:border-primary-900 relative -ml-px inline-flex cursor-default items-center rounded-r-md border bg-white px-2 py-2 text-sm font-medium leading-5 text-gray-500 dark:bg-slate-800"
                                aria-hidden="true">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
