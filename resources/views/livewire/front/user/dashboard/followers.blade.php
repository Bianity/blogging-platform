<div class="relative mx-auto w-full sm:pt-6 md:max-w-7xl">
    <h1 class="mb-5 px-4 text-3xl font-semibold dark:text-slate-200">
        <span>{{ __('Dashboard') }}</span>
        <span>/</span>
        <span>{{ __('Followers') }}</span>
    </h1>
    <div
        class="md:grid md:grid-cols-12 md:gap-2 lg:gap-4">
        <div class="col-span-3">
            <x-menu.dashboard :user="auth()->user()" />
        </div>
        <div class="col-span-9 mt-5 sm:mt-0">
            <div class="grid gap-0 sm:gap-3 md:grid-cols-2 lg:grid-cols-3">
                @forelse($followers as $follower)
                    <div class="shadow-xs rounded-md bg-white p-2 dark:bg-slate-800">
                        <a class="flex items-center rounded p-5 transition duration-300 ease-in-out hover:bg-primary-50 hover:text-primary-500 dark:text-slate-200 dark:hover:bg-primary-900 dark:hover:bg-opacity-20 hover:dark:text-primary-500"
                            href="{{ route('user.show', $follower->username) }}">
                            <div class="flex items-center">
                                <img class="mr-5 h-14 w-14 rounded shadow-sm"
                                    src="{{ $follower->getAvatar() }}"
                                    alt="{{ $follower->name ? $follower->name : $follower->username }}">
                                <div class="flex flex-col">
                                    @isset($follower->name)
                                        <div class="font-semibold">
                                            {{ $follower->name }}
                                        </div>
                                    @endisset
                                    <div>
                                        {{ '@' . $follower->username }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div
                        class="col-span-full flex w-full items-center justify-center rounded-md bg-white p-20 text-lg font-medium dark:bg-slate-800 dark:text-slate-200">
                        {{ __('You don\'t have any followers yet...') }}
                    </div>
                @endforelse
            </div>
            @if ($followers->count() > $perPage)
                <div class="mt-5 rounded-md bg-white p-4 dark:bg-slate-800">
                    {{ $followers->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
