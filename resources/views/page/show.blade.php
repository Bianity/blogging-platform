<x-app-layout>
    <div class="relative mx-auto w-full sm:pt-6 lg:max-w-5xl">
        <div class="bg-white dark:bg-slate-800 dark:text-slate-200 md:rounded-xl md:shadow">
            <div class="p-3 sm:px-10 sm:py-8">
                <h1 class="text-4xl font-semibold">{{ $page->title }}</h1>
                <div class="mt-4 space-y-4">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
