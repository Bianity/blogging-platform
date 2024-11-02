<section class="max-w-md rounded-lg bg-white dark:bg-slate-800">
    <h2 class="py-2 px-4 text-base font-semibold text-gray-900 dark:text-slate-200">
        {{ __('Popular Tags') }}
    </h2>
    <div class="flex flex-col">
        @foreach ($popularTags as $tag => $value)
            <a href="{{ route('tag.show', Str::slug(str_replace(' ', '-', $tag))) }}"
                class="group flex items-center py-2 px-4 transition duration-200 ease-in-out hover:bg-gray-50 hover:text-primary-500 last:hover:rounded-b-lg dark:text-slate-200 dark:hover:bg-slate-700 dark:hover:text-primary-500">
                <div class="flex w-full items-center justify-between gap-x-4 gap-y-3">
                    <div class="break-words text-base font-semibold">
                        #{{ $tag }}
                    </div>
                    <div
                        class="rounded-md border-2 border-transparent bg-slate-100 px-1 text-xs group-hover:border-2 group-hover:border-primary-400 group-hover:bg-primary-100 dark:bg-slate-600 dark:hover:text-white">
                        {{ $value }}
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</section>
