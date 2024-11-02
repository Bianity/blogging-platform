<div
    class="relative mx-auto flex w-full pt-6 md:grid md:grid-cols-main-md md:gap-2 md:px-2 lg:max-w-7xl lg:grid-cols-main lg:gap-4">
    <x-menu.main />
    <div class="block w-full max-w-3xl">
        <x-menu.saved />
        @foreach ($savedStories as $story)
            <livewire:front.story-card :story="$story" :key="$story->id" />
        @endforeach
        @if ($totalRecords != 0)
            @if ($savedStories->hasMorePages())
                <x-ui.skeleton />
                <div x-intersect="$wire.loadMore" class="grid grid-cols-1"></div>
            @endif
        @else
            <div
                class="flex w-full items-center justify-center rounded-md bg-white p-20 dark:bg-slate-800">
                <div class="flex flex-col items-center gap-3">
                    <x-icons.clock class="h-20 w-20 text-slate-400" />
                    <p class="text-center text-lg font-medium text-slate-500 dark:text-slate-400">
                        {{ __('You don\'t have any saved stories') }}
                    </p>
                </div>
            </div>
        @endif
    </div>
    <aside class="hidden space-y-4 lg:block">
        @if (App\Models\Story::published()->count() != 0)
            <x-widgets.top-authors />
            <x-widgets.popular-tags />
        @endif
        <div class="sticky top-20">
            @if ($advancedSettings->banner_sidebar_widget !== '')
                <section>{!! $advancedSettings->banner_sidebar_widget !!}</section>
            @endif
            <div class="mt-5">
                <x-menu.footer />
            </div>
        </div>
    </aside>
</div>
