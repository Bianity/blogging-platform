<div class="relative mx-auto w-full sm:pt-6 lg:max-w-5xl">
    <header class="space-y-3 rounded-lg bg-white dark:bg-slate-800 dark:text-slate-200">
        <livewire:front.community.cover-image :community="$community" />
        <div class="px-5">
            <div class="relative flex flex-col sm:flex-row">
                {{-- Avatar --}}
                <div class="-mt-20 flex justify-center sm:justify-start">
                    <livewire:front.community.avatar :community="$community" />
                </div>
                <div class="mt-4 flex grow items-center justify-between sm:ml-5 sm:mt-0">
                    <div class="flex flex-col">
                        <div class="text-3xl font-bold lg:text-5xl">
                            {{ $community->name }}
                        </div>
                    </div>
                    {{-- Setting and Follow Button --}}
                    <div class="flex items-center">
                        @if (auth()->id() === $community->user_id)
                            <x-buttons.default-button class="border-gray-100 dark:border-slate-700"
                                href="{{ route('community.settings', ['community' => $community->slug]) }}">
                                <x-icons.user.settings class="h-6 w-6 md2:mr-2" />
                                <span class="hidden md2:flex">{{ __('Edit') }}</span>
                            </x-buttons.default-button>
                        @endif

                        @if (auth()->id() !== $community->user_id)
                            <livewire:front.follow :model="$community" />
                        @endif
                    </div>
                </div>
            </div>
            <div class="mt-2 block sm:mt-4">
                <div class="my-2 block sm:hidden">{{ $community->description }}</div>
                <div class="flex items-center">
                    <span class="mr-2 h-5 w-5" title="{{ __('Created') }}">
                        <x-icons.user.calendar class="h-5 w-5 text-gray-500" />
                    </span>
                    {{ __('Created on') }}
                    {{ $community->created_at->toFormattedDateString() }}
                </div>
                <div class="mt-4 flex items-center space-x-5 pb-3">
                    <div>
                        <span class="font-bold">{{ $communityStoriesCount }}</span>
                        <span class="text-slate-500">{{ __('Stories') }}</span>
                    </div>
                    <div>
                        <span class="font-bold">{{ $community->followers()->count() }}</span>
                        <span class="text-slate-500">{{ __('Followers') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="mt-5 lg:grid lg:grid-cols-12 lg:gap-4">
        <div class="lg:col-span-8">
            @foreach ($communityStoriesLatest as $story)
                <livewire:front.story-card :story="$story" :key="$story->id" />
            @endforeach
            @if ($communityStoriesCount != 0)
                @if ($communityStoriesLatest->hasMorePages())
                    <x-ui.skeleton />
                    <div x-intersect="$wire.loadMore" class="grid grid-cols-1"></div>
                @endif
            @else
                <div
                    class="col-span-full flex w-full items-center justify-center rounded-md bg-white p-20 text-lg font-medium dark:bg-slate-800 dark:text-slate-200">
                    {{ __('There are no stories here yet') }}
                </div>
            @endif
        </div>
        <aside class="hidden space-y-4 md:mt-0 lg:col-span-4 lg:block">
            <div class="bg-white p-4 dark:bg-slate-800 dark:text-slate-200 sm:rounded-lg">
                <h2 class="mb-2 text-base font-semibold">{{ __('About Community') }}</h2>
                <div>{!! $community->description !!}</div>
            </div>
            @if ($community->rules)
                <div class="bg-white p-4 dark:bg-slate-800 dark:text-slate-200 sm:rounded-lg">
                    <h2 class="mb-2 text-base font-semibold">{{ __('Rules') }}</h2>
                    <div>{!! nl2br($community->rules) !!}</div>
                </div>
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
</div>
