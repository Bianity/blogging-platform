@if ((new \Jenssegers\Agent\Agent())->isDesktop() || (new \Jenssegers\Agent\Agent())->isTablet())
    <nav class="sticky top-20 hidden md:block" wire:ignore>
        <div class="mx-1">
            @if (config('alma.default_feed') === 'popular')
                {{-- Popular Stories --}}
                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'bg-white dark:bg-slate-800' : '' }} group mb-1 flex items-center rounded-md px-4 py-2.5 text-base font-semibold text-gray-900 transition duration-300 ease-in-out hover:bg-white/60 dark:text-slate-200 dark:hover:bg-slate-800"
                    aria-current="page">
                    <x-icons.flash
                        class="{{ request()->routeIs('home') ? 'text-primary-500 dark:text-primary-500' : '' }} mr-3 h-6 w-6 flex-shrink-0 text-gray-700 dark:text-slate-200" />
                    <span class="truncate">
                        {{ __('Popular') }}
                    </span>
                </a>
                {{-- Latest Stories --}}
                <a href="{{ route('latest') }}"
                    class="{{ request()->routeIs('latest') ? 'bg-white dark:bg-slate-800' : '' }} group mb-1 flex items-center rounded-md px-4 py-2.5 text-base font-semibold text-gray-600 transition duration-300 ease-in-out hover:bg-white/60 dark:text-slate-200 dark:hover:bg-slate-800">
                    <x-icons.clock
                        class="{{ request()->routeIs('latest') ? 'text-primary-500 dark:text-primary-500' : '' }} mr-3 h-6 w-6 flex-shrink-0 text-gray-700 dark:text-slate-200" />
                    <span class="truncate">
                        {{ __('Latest') }}
                    </span>
                </a>
            @else
                {{-- Latest Stories --}}
                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'bg-white dark:bg-slate-800' : '' }} group mb-1 flex items-center rounded-md px-4 py-2.5 text-base font-semibold text-gray-900 transition duration-300 ease-in-out hover:bg-white/60 dark:text-slate-200 dark:hover:bg-slate-800"
                    aria-current="page">
                    <x-icons.clock
                        class="{{ request()->routeIs('home') ? 'text-primary-500 dark:text-primary-500' : '' }} mr-3 h-6 w-6 flex-shrink-0 text-gray-700 dark:text-slate-200" />
                    <span class="truncate">
                        {{ __('Latest') }}
                    </span>
                </a>
                {{-- Popular Stories --}}
                <a href="{{ route('popular') }}"
                    class="{{ request()->routeIs('popular') ? 'bg-white dark:bg-slate-800' : '' }} group mb-1 flex items-center rounded-md px-4 py-2.5 text-base font-semibold text-gray-600 transition duration-300 ease-in-out hover:bg-white/60 dark:text-slate-200 dark:hover:bg-slate-800">
                    <x-icons.flash
                        class="{{ request()->routeIs('popular') ? 'text-primary-500 dark:text-primary-500' : '' }} mr-3 h-6 w-6 flex-shrink-0 text-gray-700 dark:text-slate-200" />
                    <span class="truncate">
                        {{ __('Popular') }}
                    </span>
                </a>
            @endif
            {{-- Featured Stories --}}
            <a href="{{ route('featured') }}"
                class="{{ request()->routeIs('featured') ? 'bg-white dark:bg-slate-800' : '' }} group mb-1 flex items-center rounded-md px-4 py-2.5 text-base font-semibold text-gray-600 transition duration-300 ease-in-out hover:bg-white/60 dark:text-slate-200 dark:hover:bg-slate-800">
                <x-icons.star-featured
                    class="{{ request()->routeIs('featured') ? 'text-primary-500 dark:text-primary-500' : '' }} mr-3 h-6 w-6 flex-shrink-0 text-gray-700 dark:text-slate-200" />
                <span class="truncate">
                    {{ __('Featured') }}
                </span>
            </a>
            {{-- Top Communities --}}
            <a href="{{ route('top.communities') }}"
                class="{{ request()->routeIs('top.communities') ? 'bg-white dark:bg-slate-800' : '' }} group mb-1 flex items-center rounded-md px-4 py-2.5 text-base font-semibold text-gray-600 transition duration-300 ease-in-out hover:bg-white/60 dark:text-slate-200 dark:hover:bg-slate-800">
                <x-icons.top-communities
                    class="{{ request()->routeIs('top.communities') ? 'text-primary-500 dark:text-primary-500' : '' }} mr-3 h-6 w-6 flex-shrink-0 text-gray-700 dark:text-slate-200" />
                <span class="truncate">
                    {{ __('Top Communities') }}
                </span>
            </a>
        </div>
        <div class="mx-5 mt-3 border-t border-slate-300 dark:border-slate-700"></div>
        <div class="mx-1 my-3">
            @auth
                <div class="mt-3">
                    {{-- Feed --}}
                    <a href="{{ route('myfeed') }}"
                        class="{{ request()->routeIs('myfeed') ? 'bg-white dark:bg-slate-800' : '' }} group mb-1 flex items-center rounded-md px-4 py-2.5 text-base font-semibold text-gray-600 transition duration-300 ease-in-out hover:bg-white/60 dark:text-slate-200 dark:hover:bg-slate-800">
                        <x-icons.user.feed
                            class="{{ request()->routeIs('myfeed') ? 'text-primary-500 dark:text-primary-500' : '' }} mr-3 h-6 w-6 flex-shrink-0 text-gray-700 dark:text-slate-200" />
                        <span class="truncate">
                            {{ __('My feed') }}
                        </span>
                    </a>
                    {{-- Saved Stories and Comments --}}
                    <a href="{{ route('saved.stories') }}"
                        class="{{ request()->routeIs('saved.stories') || request()->routeIs('saved.comments') ? 'bg-white dark:bg-slate-800' : '' }} group mb-1 flex items-center rounded-md px-4 py-2.5 text-base font-semibold text-gray-600 transition duration-300 ease-in-out hover:bg-white/60 dark:text-slate-200 dark:hover:bg-slate-800">
                        <x-icons.user.saved
                            class="{{ request()->routeIs('saved.stories') || request()->routeIs('saved.comments') ? 'text-primary-500 dark:text-primary-500' : '' }} mr-3 h-6 w-6 flex-shrink-0 text-gray-700 dark:text-slate-200" />
                        <span class="truncate">
                            {{ __('Saved') }}
                        </span>
                    </a>
                    @foreach ($userFollowings as $following)
                        <a href="{{ route('user.show', $following->followable->username) }}"
                            class="group mb-1 flex items-center rounded-md px-4 py-2.5 text-base font-semibold text-gray-600 transition duration-300 ease-in-out hover:bg-white/60 dark:text-slate-200 dark:hover:bg-slate-800">
                            <img class="h-6 w-6 rounded-lg"
                                src="{{ $following->followable->getAvatar() }}"
                                alt="{{ $following->followable->name }}">
                            <span class="ml-4">
                                {{ $following->followable->name }}
                                @if ($following->followable->stories_count > 0)
                                    {{ $following->followable->stories_count }}
                                @endif
                            </span>
                        </a>
                    @endforeach
                </div>
            @else
                @foreach ($communities as $community)
                    <a href="{{ route('community.show', ['community' => $community->slug]) }}"
                        class="group mb-1 flex items-center rounded-md px-4 py-2.5 text-gray-600 transition duration-300 ease-in-out hover:bg-white/60 dark:text-slate-200 dark:hover:bg-slate-800">
                        <img class="mr-3 h-6 w-6 rounded-lg"
                            src="{{ $community->getAvatar() }}"
                            alt="{{ $community->name }}">
                        <div class="truncate text-base font-semibold">
                            {{ $community->name }}
                        </div>
                    </a>
                @endforeach
            @endauth
        </div>
    </nav>
@endif
