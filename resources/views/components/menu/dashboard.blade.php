@auth
    <nav class="sticky top-20">
        <div class="mx-1" wire:ignore>
            <a href="{{ route('user.dashboard') }}"
                class="{{ request()->routeIs('user.dashboard') ? 'bg-white dark:bg-slate-800' : '' }} group mb-1 flex items-center rounded-md px-4 py-2.5 text-base font-semibold text-gray-900 transition duration-300 ease-in-out hover:bg-primary-100/60 dark:text-slate-200 dark:hover:bg-slate-800"
                aria-current="page">
                <div class="flex w-full items-center justify-between">
                    <div class="truncate">
                        {{ __('Stories') }}
                    </div>
                    <div class="rounded-md bg-slate-200 py-0.5 px-2 text-sm text-black">
                        {{ $user->stories()->count() }}
                    </div>
                </div>
            </a>

            <a href="{{ route('user.dashboard.followers') }}"
                class="{{ request()->routeIs('user.dashboard.followers') ? 'bg-white dark:bg-slate-800' : '' }} group mb-1 flex items-center rounded-md px-4 py-2.5 text-base font-semibold text-gray-600 transition duration-300 ease-in-out hover:bg-primary-100/60 dark:text-slate-200 dark:hover:bg-slate-800">
                <div class="flex w-full items-center justify-between">
                    <div class="truncate">
                        {{ __('Followers') }}
                    </div>
                    <div class="rounded-md bg-slate-200 py-0.5 px-2 text-sm text-black">
                        {{ $user->followers()->count() }}
                    </div>
                </div>
            </a>

            <a href="{{ route('user.dashboard.following.users') }}"
                class="{{ request()->routeIs('user.dashboard.following.users') ? 'bg-white dark:bg-slate-800' : '' }} group mb-1 flex items-center rounded-md px-4 py-2.5 text-base font-semibold text-gray-600 transition duration-300 ease-in-out hover:bg-primary-100/60 dark:text-slate-200 dark:hover:bg-slate-800">
                <div class="flex w-full items-center justify-between">
                    <div class="truncate">
                        {{ __('Following users') }}
                    </div>
                    <div class="rounded-md bg-slate-200 py-0.5 px-2 text-sm text-black">
                        {{ $user->followings()->where('followable_type', 'App\Models\User')->count() }}
                    </div>
                </div>
            </a>
            <a href="{{ route('user.dashboard.following.communities') }}"
                class="{{ request()->routeIs('user.dashboard.following.communities') ? 'bg-white dark:bg-slate-800' : '' }} group mb-1 flex items-center rounded-md px-4 py-2.5 text-base font-semibold text-gray-600 transition duration-300 ease-in-out hover:bg-primary-100/60 dark:text-slate-200 dark:hover:bg-slate-800">
                <div class="flex w-full items-center justify-between">
                    <div class="truncate">
                        {{ __('Following communities') }}
                    </div>
                    <div class="rounded-md bg-slate-200 py-0.5 px-2 text-sm text-black">
                        {{ $user->followings()->where('followable_type', 'App\Models\Community')->count() }}
                    </div>
                </div>
            </a>
        </div>
    </nav>
@endauth
