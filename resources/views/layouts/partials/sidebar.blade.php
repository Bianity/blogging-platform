<div>
    <div
        class="fixed inset-0 z-50 h-screen overflow-y-auto bg-gray-900 bg-opacity-50 transition-opacity duration-200 dark:bg-slate-900 dark:bg-opacity-50 lg:z-auto lg:hidden"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'"
        aria-hidden="true"
        x-cloak></div>
    <div
        class="fixed left-0 top-0 z-50 block h-screen w-72 shrink-0 transform overflow-y-auto bg-slate-100 transition-all duration-200 ease-in-out dark:bg-slate-900 md:border-secondary-200 lg:left-auto lg:top-auto lg:hidden lg:translate-x-0 lg:sidebar-expanded:!w-72 2xl:!w-72"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-72'"
        @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false"
        x-cloak="lg">
        <div class="flex h-screen flex-col justify-between">
            <div>
                <div class="mb-8 flex items-center sm:px-2">
                    <button class="justify-start pl-3 text-gray-900 hover:text-slate-400 dark:text-slate-200 lg:hidden"
                        @click.stop="sidebarOpen = !sidebarOpen"
                        aria-controls="sidebar" :aria-expanded="sidebarOpen">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-7 w-7 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                        </svg>
                    </button>
                    <a class="ml-8 block h-10 max-w-[200px] pt-3" href="{{ route('home') }}">
                        @if (!empty($generalSettings->site_logo) && !empty($generalSettings->site_logo_dark))
                            <img src="{{ Storage::disk(getCurrentDisk())->url($generalSettings->site_logo) }}"
                                class="h-full w-full object-contain"
                                :class="{ 'hidden': $store.darkMode.state }"
                                {{ $attributes }} alt="logo" />
                            <img src="{{ Storage::disk(getCurrentDisk())->url($generalSettings->site_logo_dark) }}"
                                class="h-full w-full object-contain"
                                :class="{ 'hidden': !$store.darkMode.state }"
                                {{ $attributes }} alt="logo" />
                        @else
                            <img src="{{ asset('images/logo.svg') }}"
                                class="h-full w-full object-contain"
                                :class="{ 'hidden': $store.darkMode.state }"
                                {{ $attributes }} alt="logo" />
                            <img src="{{ asset('images/logo-dark.svg') }}"
                                class="h-full w-full object-contain"
                                :class="{ 'hidden': !$store.darkMode.state }"
                                {{ $attributes }} alt="logo" />
                        @endif
                    </a>
                </div>
                <nav class="justify-start">
                    <div class="mx-2" wire:ignore>
                        @if (config('alma.default_feed') === 'popular')
                            {{-- Popular - Home page --}}
                            <a href="{{ route('home') }}"
                                class="{{ request()->routeIs('home') ? 'bg-white dark:bg-slate-800' : '' }} group mb-3 flex items-center rounded-md px-4 py-2.5 text-lg font-semibold text-gray-900 transition duration-300 ease-in-out hover:bg-white/60 dark:text-slate-200 dark:hover:bg-slate-800"
                                aria-current="page">
                                <x-icons.flash
                                    class="{{ request()->routeIs('home') ? 'text-primary-500 dark:text-primary-500' : '' }} mr-3 h-6 w-6 flex-shrink-0 text-gray-700 dark:text-slate-200" />
                                <span class="truncate">
                                    {{ __('Popular') }}
                                </span>
                            </a>
                            {{-- Latest --}}
                            <a href="{{ route('latest') }}"
                                class="{{ request()->routeIs('latest') ? 'bg-white dark:bg-slate-800' : '' }} group mb-3 flex items-center rounded-md px-4 py-2.5 text-lg font-semibold text-gray-600 transition duration-300 ease-in-out hover:bg-white/60 dark:text-slate-200 dark:hover:bg-slate-800">
                                <x-icons.clock
                                    class="{{ request()->routeIs('latest') ? 'text-primary-500 dark:text-primary-500' : '' }} mr-3 h-6 w-6 flex-shrink-0 text-gray-700 dark:text-slate-200" />
                                <span class="truncate">
                                    {{ __('Latest') }}
                                </span>
                            </a>
                        @else
                            {{-- Latest - Home page --}}
                            <a href="{{ route('home') }}"
                                class="{{ request()->routeIs('home') ? 'bg-white dark:bg-slate-800' : '' }} group mb-3 flex items-center rounded-md px-4 py-2.5 text-lg font-semibold text-gray-900 transition duration-300 ease-in-out hover:bg-white/60 dark:text-slate-200 dark:hover:bg-slate-800"
                                aria-current="page">
                                <x-icons.clock
                                    class="{{ request()->routeIs('home') ? 'text-primary-500 dark:text-primary-500' : '' }} mr-3 h-6 w-6 flex-shrink-0 text-gray-700 dark:text-slate-200" />
                                <span class="truncate">
                                    {{ __('Latest') }}
                                </span>
                            </a>
                            {{-- Popular --}}
                            <a href="{{ route('popular') }}"
                                class="{{ request()->routeIs('popular') ? 'bg-white dark:bg-slate-800' : '' }} group mb-3 flex items-center rounded-md px-4 py-2.5 text-lg font-semibold text-gray-600 transition duration-300 ease-in-out hover:bg-white/60 dark:text-slate-200 dark:hover:bg-slate-800">
                                <x-icons.flash
                                    class="{{ request()->routeIs('popular') ? 'text-primary-500 dark:text-primary-500' : '' }} mr-3 h-6 w-6 flex-shrink-0 text-gray-700 dark:text-slate-200" />
                                <span class="truncate">
                                    {{ __('Popular') }}
                                </span>
                            </a>
                        @endif

                        {{-- Featured --}}
                        <a href="{{ route('featured') }}"
                            class="{{ request()->routeIs('featured') ? 'bg-white dark:bg-slate-800' : '' }} group mb-3 flex items-center rounded-md px-4 py-2.5 text-lg font-semibold text-gray-600 transition duration-300 ease-in-out hover:bg-white/60 dark:text-slate-200 dark:hover:bg-slate-800">
                            <x-icons.star-featured
                                class="{{ request()->routeIs('featured') ? 'text-primary-500 dark:text-primary-500' : '' }} mr-3 h-6 w-6 flex-shrink-0 text-gray-700 dark:text-slate-200" />
                            <span class="truncate">
                                {{ __('Featured') }}
                            </span>
                        </a>
                        {{-- Feed --}}
                        @auth
                            <a href="{{ route('myfeed') }}"
                                class="{{ request()->routeIs('myfeed') ? 'bg-white dark:bg-slate-800' : '' }} group mb-3 flex items-center rounded-md px-4 py-2.5 text-lg font-semibold text-gray-600 transition duration-300 ease-in-out hover:bg-white/60 dark:text-slate-200 dark:hover:bg-slate-800">
                                <x-icons.user.feed
                                    class="{{ request()->routeIs('myfeed') ? 'text-primary-500 dark:text-primary-500' : '' }} mr-3 h-6 w-6 flex-shrink-0 text-gray-700 dark:text-slate-200" />
                                <span class="truncate">
                                    {{ __('My feed') }}
                                </span>
                            </a>
                        @endauth
                        {{-- Saved Stories and Comments --}}
                        @auth
                            <a href="{{ route('saved.stories') }}"
                                class="{{ request()->routeIs('saved.stories') || request()->routeIs('saved.comments') ? 'bg-white dark:bg-slate-800' : '' }} group mb-3 flex items-center rounded-md px-4 py-2.5 text-lg font-semibold text-gray-600 transition duration-300 ease-in-out hover:bg-white/60 dark:text-slate-200 dark:hover:bg-slate-800">
                                <x-icons.user.saved
                                    class="{{ request()->routeIs('saved.stories') || request()->routeIs('saved.comments') ? 'text-primary-500 dark:text-primary-500' : '' }} mr-3 h-6 w-6 flex-shrink-0 text-gray-700 dark:text-slate-200" />
                                <span class="truncate">
                                    {{ __('Saved') }}
                                </span>
                            </a>
                        @endauth
                        {{-- Top Communities --}}
                        <a href="{{ route('top.communities') }}"
                            class="{{ request()->routeIs('top.communities') ? 'bg-white dark:bg-slate-800' : '' }} group mb-3 flex items-center rounded-md px-4 py-2.5 text-lg font-semibold text-gray-600 transition duration-300 ease-in-out hover:bg-white/60 dark:text-slate-200 dark:hover:bg-slate-800">
                            <x-icons.top-communities
                                class="{{ request()->routeIs('top.communities') ? 'text-primary-500 dark:text-primary-500' : '' }} mr-3 h-6 w-6 flex-shrink-0 text-gray-700 dark:text-slate-200" />
                            <span class="truncate">
                                {{ __('Top Communities') }}
                            </span>
                        </a>
                        @if (Auth::guest())
                            <x-buttons.primary-button href="{{ route('login') }}"
                                fullWidth class="my-4 h-12 text-lg font-semibold">
                                <span class="truncate">
                                    {{ __('Write a story') }}
                                </span>
                            </x-buttons.primary-button>
                        @else
                            @can('add_stories')
                                <x-buttons.primary-button href="{{ route('story.create') }}"
                                    fullWidth class="my-4 h-12 text-lg font-semibold">
                                    <span class="truncate">
                                        {{ __('Write a story') }}
                                    </span>
                                </x-buttons.primary-button>
                            @else
                                <x-buttons.primary-button
                                    fullWidth class="my-4 h-12 text-lg font-semibold">
                                    <span class="truncate">
                                        {{ __('Write a story') }}
                                    </span>
                                </x-buttons.primary-button>
                            @endcan
                        @endif
                    </div>
                    <div class="mx-1 mt-6">
                        <x-menu.footer />
                    </div>
                </nav>
            </div>
            <div class="flex-row">
                <div class="bg-primary flex h-14 w-full grow-0 items-center justify-center p-3 dark:bg-slate-900">
                    <button
                        x-data @click="$store.darkMode.toggle()"
                        type="button"
                        aria-pressed="false"
                        aria-label="darkMode"
                        class="darkModeToggle h-7.5 relative my-3 inline-flex w-14 shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-primary_darker transition-colors duration-200 ease-in-out focus:outline-none dark:bg-secondary-800">
                        <span
                            class="relative inline-block h-7 w-7 translate-x-0 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out dark:translate-x-6">
                            <span x-show="!$store.darkMode.state"
                                class="absolute inset-0 flex h-full w-full items-center justify-center opacity-100 transition-opacity duration-200 ease-in dark:hidden dark:opacity-0 dark:duration-100 dark:ease-out"
                                aria-hidden="true">
                                <x-icons.sun />
                            </span>
                            <span x-show="$store.darkMode.state"
                                class="absolute inset-0 hidden h-full w-full items-center justify-center opacity-0 transition-opacity delay-150 duration-200 ease-out dark:flex dark:opacity-100 dark:duration-100 dark:ease-out"
                                aria-hidden="true">
                                <x-icons.moon />
                            </span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
