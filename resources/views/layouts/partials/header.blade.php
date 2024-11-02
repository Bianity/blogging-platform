<header
    class="sticky top-0 z-10 h-16 w-full bg-primary_light px-2 transition-colors duration-500 dark:border-slate-50/[0.06] dark:bg-slate-900 dark:bg-opacity-80 sm:px-4 lg:overflow-y-visible lg:border-b lg:border-slate-500/10">
    <div class="grid-cols-full grid h-16 w-full items-center justify-between sm:grid-cols-header">
        <div class="row-span-full flex items-center">
            @if ((new \Jenssegers\Agent\Agent())->isMobile() || (new \Jenssegers\Agent\Agent())->isTablet())
                <div class="mr-6 flex md:mr-4 lg:hidden">
                    <button
                        class="text-gray-500 hover:text-gray-600 lg:hidden"
                        @click.stop="sidebarOpen = !sidebarOpen"
                        aria-controls="sidebar"
                        :aria-expanded="sidebarOpen">
                        <span class="sr-only">Open sidebar</span>
                        <x-icons.menu-hamburger x-cloak class="h-7 w-7 text-gray-900 dark:text-slate-200" />
                    </button>
                </div>
            @endif
            <a class="block h-10 max-w-[220px]" href="{{ route('home') }}" x-cloak>
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
        <div class="row-span-full flex lg:col-start-2 lg:col-end-auto">
            <div class="hidden w-full items-center md2:flex xl:max-w-[380px]">
                <div class="w-full">
                    <livewire:front.search-bar id="searchMobileID" />
                </div>
            </div>
        </div>
        <div
            class="row-span-full hidden items-center justify-self-end xl:col-start-2 xl:col-end-auto xl:flex">
            @if (Auth::guest())
                <x-buttons.default-button class="font-semibold" href="{{ route('login') }}">
                    <x-icons.plus class="h-5 w-5 md2:mr-2" />
                    <span class="hidden md2:block">
                        {{ __('Write') }}
                    </span>
                </x-buttons.default-button>
            @else
                @can('add_stories')
                    <x-buttons.default-button href="{{ route('story.create') }}" class="font-semibold">
                        <x-icons.plus class="h-5 w-5 md2:mr-2" />
                        <span class="hidden md2:block">
                            {{ __('Write') }}
                        </span>
                    </x-buttons.default-button>
                @else
                    <x-buttons.default-button class="font-semibold">
                        <x-icons.plus class="h-5 w-5 md2:mr-2" />
                        <span class="hidden md2:block">
                            {{ __('Write') }}
                        </span>
                    </x-buttons.default-button>
                @endcan
            @endif
        </div>
        <div class="row-span-full flex items-center space-x-5 justify-self-end">
            <div class="flex h-full md2:hidden" x-cloak x-data="{ show: false }">
                <button @click="show = !show"
                    :aria-expanded="show ? 'true' : 'false'">
                    <x-icons.search-mobile class="h-6 w-6 text-gray-900 dark:text-slate-200" />
                </button>
                <div class="supports-backdrop-blur:bg-white/60 absolute left-0 right-0 mt-10 w-full bg-primary_light px-2 pb-4 pt-2 backdrop-blur transition-colors duration-500 dark:bg-slate-900"
                    x-show="show"
                    x-transition x-on:click.away="show = false" @keydown.escape="show = false">
                    <livewire:front.search-bar id="searchID" />
                </div>
            </div>
            @auth()
                <livewire:front.notifications />
            @endauth
            @if ((new \Jenssegers\Agent\Agent())->isDesktop())
                @guest()
                    <a href="{{ route('login') }}"
                        class="group hidden items-center py-2 text-gray-900 sm:flex sm:px-4"
                        aria-label="{{ __('Login') }}">
                        <x-icons.user.login class="mr-4 h-7 w-7 group-hover:text-primary-500 dark:text-slate-200" />
                        <span class="text-base font-medium group-hover:text-primary-500 dark:text-slate-200">
                            {{ __('Login') }}
                        </span>
                    </a>
                @endguest
                @auth()
                    <div class="hidden items-center sm:flex">
                        <x-ui.dropdown align="right" width="64">
                            <x-slot name="trigger">
                                <button class="inline-flex max-w-xs items-center justify-center rounded-md p-2">
                                    <img class="h-10 w-10 rounded-full" src="{{ auth()->user()->getAvatar() }}"
                                        alt="avatar" />
                                    <x-icons.chevron-down class="ml-1" />
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <div class="p-2">
                                    {{-- Admin panel --}}
                                    @if (auth()->user()->isAdmin())
                                        <x-ui.dropdown-link
                                            href="{{ route('filament.cp.pages.dashboard') }}"
                                            class="flex items-center rounded-lg">
                                            <x-icons.user.admin-dashboard
                                                class="mr-3 h-6 w-6 text-black dark:text-slate-200" />
                                            <span
                                                class="text-base font-bold">{{ __('Admin panel') }}</span>
                                        </x-ui.dropdown-link>
                                        <div class="-mx-2 my-2 border-t border-gray-100 dark:border-slate-700"></div>
                                    @endif
                                    {{-- Communities --}}
                                    @if (auth()->user()->countCommunities())
                                        <div class="relative -mx-2" x-data="{ accordion: false }">
                                            <button type="button"
                                                class="w-full px-6 py-3 text-left"
                                                @click="accordion = !accordion"
                                                :class="accordion ? 'bg-primary-50 text-primary-500 dark:text-primary-500' :
                                                    'bg-gray-100 dark:bg-slate-700 dark:text-slate-200'">
                                                <div
                                                    class="flex items-center justify-between transition duration-150 ease-in">
                                                    <span class="font-semibold">{{ __('My Communities') }}</span>
                                                    <svg x-show="!accordion"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M8.46997 10.74L12 14.26L15.53 10.74" stroke="currentColor"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>

                                                    <svg x-show="accordion" class="text-primary-500"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                                            stroke="currentColor" stroke-width="1.5"
                                                            stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M8.46997 13.26L12 9.73999L15.53 13.26"
                                                            stroke="currentColor"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </div>
                                            </button>
                                            <div
                                                x-show.transition.duration.300ms.origin.bottom="accordion"
                                                @click.away="accordion = false"
                                                class="relative max-h-56 overflow-y-auto p-2 transition-all duration-700">
                                                @foreach (auth()->user()->getCommunityForMenu() as $community)
                                                    <x-ui.dropdown-link
                                                        href="{{ route('community.show', ['community' => $community->slug]) }}"
                                                        class="-m- mb-1 flex items-center rounded-lg">
                                                        @isset($community->avatar)
                                                            <img class="mr-3 h-6 w-6 rounded"
                                                                src="{{ $community->getAvatar() }}"
                                                                alt="{{ $community->name }}" />
                                                        @endisset
                                                        <span
                                                            class="text-base font-bold">{{ Str::ucfirst($community->name) }}</span>
                                                    </x-ui.dropdown-link>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="-mx-2 my-2 border-t border-gray-100 dark:border-slate-700"></div>
                                    @endif
                                    {{-- Profile --}}
                                    <div class="block px-4 py-2 text-xs text-gray-500">
                                        {{ __('Profile') }}
                                    </div>
                                    <x-ui.dropdown-link href="{{ route('user.show', ['user' => auth()->user()]) }}"
                                        class="mb-1 flex items-center rounded-lg">
                                        <img class="mr-3 h-6 w-6 rounded" src="{{ auth()->user()->getAvatar() }}"
                                            alt="avatar" />
                                        <span
                                            class="text-base font-bold">{{ Str::ucfirst(auth()->user()->username) }}</span>
                                    </x-ui.dropdown-link>
                                    {{-- Write a story --}}
                                    @can('add_stories')
                                        <x-ui.dropdown-link
                                            href="{{ route('story.create') }}"
                                            class="mb-1 flex items-center rounded-lg">
                                            <x-icons.plus class="mr-3 h-5 w-5" />
                                            <span
                                                class="text-base">{{ __('Write a story') }}</span>
                                        </x-ui.dropdown-link>
                                    @endcan
                                    {{-- Create Community --}}
                                    @can('add_communities')
                                        <x-ui.dropdown-link
                                            href="{{ route('community.create') }}"
                                            class="mb-1 flex items-center rounded-lg">
                                            <x-icons.user.community class="mr-3 h-5 w-5" />
                                            <span
                                                class="text-base">{{ __('Create a Community') }}</span>
                                        </x-ui.dropdown-link>
                                    @endcan
                                    {{-- User Dashboard --}}
                                    <x-ui.dropdown-link
                                        href="{{ route('user.dashboard') }}"
                                        class="mb-1 flex items-center rounded-lg">
                                        <x-icons.user.dashboard class="mr-3 h-5 w-5" />
                                        <span
                                            class="text-base">{{ __('Dashboard') }}</span>
                                    </x-ui.dropdown-link>
                                    {{-- Saved --}}
                                    <x-ui.dropdown-link
                                        href="{{ route('saved.stories') }}"
                                        class="mb-1 flex items-center rounded-lg">
                                        <x-icons.user.saved class="mr-3 h-5 w-5" />
                                        <span
                                            class="text-base">{{ __('Saved') }}</span>
                                    </x-ui.dropdown-link>
                                    {{-- Account Settings --}}
                                    <x-ui.dropdown-link
                                        href="{{ route('user.settings', ['user' => auth()->user()]) }}"
                                        class="mb-1 flex items-center rounded-lg">
                                        <x-icons.user.settings class="mr-3 h-5 w-5" />
                                        <span
                                            class="text-base">{{ __('Settings') }}</span>
                                    </x-ui.dropdown-link>
                                    {{-- Log Out --}}
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-ui.dropdown-link href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                    this.closest('form').submit();"
                                            class="flex items-center rounded-lg">
                                            <x-icons.user.logout class="mr-3 h-5 w-5 text-red-600 dark:text-red-400" />
                                            <span
                                                class="text-base text-red-600 dark:text-red-400">{{ __('Log Out') }}</span>
                                        </x-ui.dropdown-link>
                                    </form>
                                </div>
                            </x-slot>
                        </x-ui.dropdown>
                    </div>
                @endauth
                <button
                    x-data @click="$store.darkMode.toggle()"
                    type="button"
                    aria-pressed="false"
                    aria-label="darkMode"
                    class="darkModeToggle h-7.5 relative my-3 hidden w-14 shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-primary_darker transition-colors duration-200 ease-in-out focus:outline-none dark:bg-secondary-800 lg:flex">
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
            @endif
        </div>
    </div>
</header>
