<div class="relative mx-auto w-full sm:pt-6 md:max-w-7xl">
    <h1 class="mb-5 px-4 text-3xl font-semibold dark:text-slate-200">
        <span>{{ __('Dashboard') }}</span>
        <span>/</span>
        <span>{{ __('Following Users') }}</span>
    </h1>
    <div
        class="md:grid md:grid-cols-12 md:gap-2 lg:gap-4">
        <div class="col-span-3">
            <x-menu.dashboard :user="getCurrentUser()" />
        </div>
        <div class="col-span-9 mt-5 sm:mt-0">
            <div class="grid gap-0 sm:gap-3 md:grid-cols-2 lg:grid-cols-3">
                @forelse($followings as $following)
                    <div class="shadow-xs rounded-md bg-white p-2 dark:bg-slate-800">
                        <a class="flex items-center rounded p-5 transition duration-300 ease-in-out hover:bg-primary-50 hover:text-primary-500 dark:text-slate-200 dark:hover:bg-primary-900 dark:hover:bg-opacity-20 hover:dark:text-primary-500"
                            href="{{ route('user.show', $following->followable->username) }}">
                            <div class="flex items-center">
                                <img class="mr-5 h-14 w-14 rounded shadow-sm"
                                    src="{{ $following->followable->getAvatar() }}"
                                    alt="{{ $following->followable->name ? $following->followable->name : $following->followable->username }}">
                                <div class="flex flex-col">
                                    @isset($following->followable->name)
                                        <div class="font-semibold">
                                            {{ $following->followable->name }}
                                        </div>
                                    @endisset
                                    <div>
                                        {{ '@' . $following->followable->username }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div
                        class="col-span-full flex w-full items-center justify-center rounded-md bg-white p-20 text-lg font-medium dark:bg-slate-800 dark:text-slate-200">
                        {{ __('You don\'t follow any user yet...') }}
                    </div>
                @endforelse
            </div>
            @if ($followings->count() > $perPage)
                <div class="mt-5 rounded-md bg-white p-4 dark:bg-slate-800">
                    {{ $followings->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
