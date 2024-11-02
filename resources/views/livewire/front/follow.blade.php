<div>
    @auth
        <button wire:click='toggleFollow'>
            @if (auth()->user()->isFollowing($model))
                <div class="inline-flex items-center rounded-lg bg-unfollow px-3 py-2 shadow transition duration-300 ease-in-out hover:bg-unfollow/80 hover:shadow-md focus:outline-none dark:hover:bg-unfollow/70"
                    title="{{ __('Following') }}">
                    <x-icons.close-square class="mr-0 hidden h-6 w-6 text-white md:mr-3 md:block" />
                    <span
                        class="text-base font-semibold leading-6 text-white">
                        {{ __('Following') }}</span>
                </div>
            @endif

            @if (!auth()->user()->isFollowing($model))
                <div
                    class="inline-flex items-center justify-center rounded-lg bg-primary-500 px-3 py-2 shadow transition duration-300 ease-in-out hover:bg-primary-600 hover:shadow-md focus:outline-none"
                    title="{{ __('Follow') }}">
                    <x-icons.user.user-add class="mr-0 hidden h-6 w-6 text-white md:mr-3 md:block" />
                    <span
                        class="text-base font-semibold leading-6 text-white">{{ __('Follow') }}</span>
                </div>
            @endif
        </button>
    @else
        <x-buttons.primary-button href="{{ route('login') }}"
            title="{{ __('Follow') }}" aria-label="{{ __('Follow') }}">
            <x-icons.user.user-add class="mr-0 hidden h-6 w-6 text-white md:mr-3 md:block" />
            <span
                class="text-base font-semibold leading-6 text-white">{{ __('Follow') }}</span>
        </x-buttons.primary-button>
    @endauth
</div>
