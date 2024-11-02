<div
    class="relative mx-auto flex w-full pt-6 md:grid md:grid-cols-main-md md:gap-2 md:px-2 lg:max-w-7xl lg:grid-cols-main lg:gap-4">
    <x-menu.main />
    <div class="block w-full max-w-3xl">
        {{-- Top Communities --}}
        <section class="w-full bg-white dark:bg-slate-800 sm:rounded-lg">
            @forelse ($communitiesList as $community)
                <div class="flex items-center p-2 sm:p-5">
                    <div class="mr-1 w-4">
                        <span class="flex items-center text-base font-semibold text-black dark:text-slate-100">
                            {{ $loop->iteration }}
                        </span>
                    </div>
                    <div class="mx-3">
                        <a href="{{ route('community.show', ['community' => $community->slug]) }}">
                            <img class="h-10 w-10 shrink-0 rounded-full" src="{{ $community->getAvatar() }}"
                                alt="{{ $community->name }}">
                        </a>
                    </div>
                    <div class="ml-3 grow flex-col">
                        <a
                            class="text-lg font-semibold hover:text-primary-600 dark:text-slate-200 dark:hover:text-primary-600"
                            href="{{ route('community.show', ['community' => $community->slug]) }}">{{ $community->name }}</a>
                        <div class="text-sm dark:text-slate-300 sm:text-base">{!! $community->description !!}</div>
                    </div>
                    <div class="hidden w-32 flex-col text-right text-sm dark:text-slate-200 sm:flex">
                        <span>{{ $community->followers()->count() }} {{ __('Followers') }}</span>
                        <span>{{ $community->stories()->count() }} {{ __('Stories') }}</span>
                    </div>
                </div>
            @empty
                <div
                    class="flex w-full items-center justify-center rounded-md bg-white p-20 dark:bg-slate-800">
                    <div class="flex flex-col items-center gap-3">
                        <x-icons.user.community class="h-20 w-20 text-slate-400" />
                        <p class="text-center text-lg font-medium text-slate-500 dark:text-slate-400">
                            {{ __('No communities yet') }}
                        </p>
                    </div>
                </div>
            @endforelse
        </section>
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
