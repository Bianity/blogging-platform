<div
    class="relative mx-auto flex w-full pt-6 md:grid md:grid-cols-main-md md:gap-2 md:px-2 lg:max-w-7xl lg:grid-cols-main lg:gap-4">
    <x-menu.main />
    <div class="block w-full max-w-3xl">
        <div class="mb-5 px-1 sm:mb-3 sm:px-0">
            <div x-data="{ activeTab: 'Today', active: @entangle('selectedPeriod').live }"
                class="col-span-full grid w-full grid-cols-4 rounded-lg bg-slate-200 p-1 text-slate-600 dark:bg-slate-800 dark:text-slate-200">
                <button
                    @click.prevent="active = 1"
                    @click="activeTab = 'Today'"
                    :class="activeTab === 'Today' ?
                        'bg-white shadow dark:bg-slate-700 dark:text-slate-100' :
                        'hover:text-slate-800 focus:text-slate-800 dark:hover:text-slate-100 dark:focus:text-slate-100'"
                    class="shrink-0 rounded-lg px-3 py-1 font-medium transition duration-200 ease-linear">{{ __('Today') }}
                </button>
                <button
                    @click.prevent="active = 7"
                    @click="activeTab = 'Week'"
                    :class="activeTab === 'Week' ?
                        'bg-white shadow dark:bg-slate-700 dark:text-slate-100' :
                        'hover:text-slate-800 focus:text-slate-800 dark:hover:text-slate-100 dark:focus:text-slate-100'"
                    class="shrink-0 rounded-lg px-3 py-1 font-medium transition duration-200 ease-linear">{{ __('Week') }}
                </button>
                <button
                    @click.prevent="active = 30"
                    @click="activeTab = 'Month'"
                    :class="activeTab === 'Month' ?
                        'bg-white shadow dark:bg-slate-700 dark:text-slate-100' :
                        'hover:text-slate-800 focus:text-slate-800 dark:hover:text-slate-100 dark:focus:text-slate-100'"
                    class="shrink-0 rounded-lg px-3 py-1 font-medium transition duration-200 ease-linear">{{ __('Month') }}
                </button>
                <button
                    @click.prevent="active = 365"
                    @click="activeTab = 'Year'"
                    :class="activeTab === 'Year' ?
                        'bg-white shadow dark:bg-slate-700 dark:text-slate-100' :
                        'hover:text-slate-800 focus:text-slate-800 dark:hover:text-slate-100 dark:focus:text-slate-100'"
                    class="shrink-0 rounded-lg px-3 py-1 font-medium transition duration-200 ease-linear">{{ __('Year') }}
                </button>
            </div>
        </div>
        @foreach ($storiesPopular as $story)
            <livewire:front.story-card :story="$story" :key="$story->id" />
        @endforeach
        @if ($totalRecords != 0)
            @if ($storiesPopular->hasMorePages())
                <x-ui.skeleton />
                <div x-intersect="$wire.loadMore" class="grid grid-cols-1"></div>
            @endif
        @else
            <div
                class="flex w-full items-center justify-center rounded-md bg-white p-20 dark:bg-slate-800">
                <div class="flex flex-col items-center gap-3">
                    <x-icons.clock class="h-20 w-20 text-slate-400" />
                    <p class="text-lg font-medium text-slate-500 dark:text-slate-400">
                        {{ __('No published stories yet') }}</p>
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
