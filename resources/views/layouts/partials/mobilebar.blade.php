<div
    class="fixed bottom-0 left-0 right-0 z-0 flex h-14 items-center justify-around border-t border-gray-200 bg-white px-4 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 sm:hidden">
    @if (config('alma.default_feed') === 'popular')
        <a href="{{ route('home') }}"
            class="@if (request()->routeIs('home')) text-primary-500 @endif flex h-full w-full items-center justify-center">
            <x-icons.home class="h-8 w-8" />
        </a>
        <a href="{{ route('latest') }}"
            class="@if (request()->routeIs('latest')) text-primary-500 @endif flex h-full w-full items-center justify-center">
            <x-icons.clock class="h-8 w-8" />
        </a>
    @else
        <a href="{{ route('home') }}"
            class="@if (request()->routeIs('home')) text-primary-500 @endif flex h-full w-full items-center justify-center">
            <x-icons.home class="h-8 w-8" />
        </a>
        <a href="{{ route('popular') }}"
            class="@if (request()->routeIs('popular')) text-primary-500 @endif flex h-full w-full items-center justify-center">
            <x-icons.flash class="h-8 w-8" />
        </a>
    @endif
    @auth()
        <div class="flex h-full w-full items-center justify-center">
            <x-ui.dropdown align="bottom" width="64">
                <x-slot name="trigger">
                    <div
                        class="@if (request()->routeIs('user.show')) border-2 border-primary-500 rounded-full @endif flex h-full w-full items-center justify-center">
                        <img class="h-8 w-8 rounded-full" src="{{ auth()->user()->getAvatar() }}"
                            alt="avatar" />
                    </div>
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
                            <div class="-mx-2 my-2 border-t border-gray-100 dark:border-slate-700">
                            </div>
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
                                        class="flex items-center justify-between transition duration-300 ease-in-out">
                                        <span class="font-semibold">{{ __('My Communities') }}</span>
                                        <svg x-show="!accordion"
                                            width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M8.46997 10.74L12 14.26L15.53 10.74" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>

                                        <svg x-show="accordion" class="text-primary-500"
                                            width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M8.46997 13.26L12 9.73999L15.53 13.26" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </button>
                                <div
                                    x-show.transition.duration.300ms.origin.bottom="accordion"
                                    @click.away="accordion = false"
                                    class="relative h-28 overflow-y-auto p-2 transition-all duration-700">
                                    @foreach (auth()->user()->getCommunityForMenu() as $community)
                                        <x-ui.dropdown-link
                                            href="{{ route('community.show', ['community' => $community->slug]) }}"
                                            class="mb-1 flex items-center rounded-lg">
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
                        <form id="logout-mobilebar-form" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-ui.dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); document.getElementById('logout-mobilebar-form').submit();"
                                class="flex items-center rounded-lg">
                                <x-icons.user.logout
                                    class="mr-3 h-5 w-5 text-red-600 dark:text-red-400" />
                                <span
                                    class="text-base text-red-600 dark:text-red-400">{{ __('Log Out') }}</span>
                            </x-ui.dropdown-link>
                        </form>
                    </div>
                </x-slot>
            </x-ui.dropdown>
        </div>
    @else
        <a href="{{ route('login') }}" class="flex h-full w-full items-center justify-center"
            aria-label="{{ __('Login') }}">
            <x-icons.user.login class="h-8 w-8" />
        </a>
    @endauth
</div>
