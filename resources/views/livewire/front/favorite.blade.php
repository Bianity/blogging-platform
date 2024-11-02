<div>
    @auth
        <button
            wire:click='toggleFavorite'
            class="group item-center mr-4 flex text-gray-400 hover:text-gray-500 dark:text-slate-200 dark:hover:text-slate-300 md:mr-7"
            aria-label="{{ __('Favorite') }}">
            @if (!auth()->user()->hasFavorited($model))
                <div class="flex h-8 w-8 items-center justify-center rounded-lg group-hover:bg-orange-500/10"
                    title="{{ __('Save') }}">
                    <x-icons.user.saved
                        class="h-5 w-5 text-gray-600 transition duration-150 ease-out group-hover:text-orange-500 dark:text-slate-200" />
                </div>
            @endif

            @if (auth()->user()->hasFavorited($model))
                <div class="flex h-8 w-8 items-center justify-center rounded-lg group-hover:bg-orange-500/10"
                    title="{{ __('Saved') }}">
                    <x-icons.user.saved-active
                        class="h-5 w-5 text-orange-500 transition duration-150 ease-in group-hover:text-orange-500 dark:text-orange-500" />
                </div>
            @endif
        </button>
    @else
        <a href="{{ route('login') }}"
            class="group item-center mr-4 flex text-gray-400 hover:text-gray-500 dark:text-slate-200 dark:hover:text-slate-300 md:mr-7"
            aria-label="{{ __('Save') }}">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg group-hover:bg-orange-500/10"
                title="{{ __('Save') }}">
                <x-icons.user.saved
                    class="h-5 w-5 text-gray-600 transition duration-150 ease-out group-hover:text-orange-500 dark:text-slate-200" />
            </div>
        </a>
    @endauth
</div>
