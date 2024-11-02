<div class="mx-auto flex w-full flex-col gap-y-8 py-4">
    <div class="flex flex-col gap-4 px-2 sm:flex-row sm:items-center sm:justify-between">
        <div class="text-xl font-semibold">
            {{ __('Clear all website cache') }}
        </div>
        <x-filament::button icon="heroicon-m-trash" color="success" wire:click="cacheClearAll" spinner="cacheClearAll"
            loading-delay="long">
            {{ __('Clear all') }}
        </x-filament::button>
    </div>

    <div class="rounded-xl bg-white p-6 shadow dark:bg-gray-900 sm:overflow-hidden">
        <div class="flex flex-col gap-4">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div class="pr-8">
                    <h2 class="font-bold dark:text-gray-100">{{ __('Cache') }}</h2>
                    <p class="my-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Flush the application cache') }}
                    </p>
                </div>
                <div class="flex">
                    <x-filament::button icon="heroicon-m-trash" color="success" wire:click="cacheClear"
                        spinner="cacheClear"
                        loading-delay="long">
                        {{ __('Clear') }}
                    </x-filament::button>
                </div>
            </div>
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div class="pr-8">
                    <h2 class="font-bold dark:text-gray-100">{{ __('Views') }}</h2>
                    <p class="my-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Caching or clearing all compiled view files') }}
                    </p>
                </div>
                <div class="flex items-center gap-x-2">
                    <x-filament::button icon="heroicon-m-rocket-launch" color="gray" wire:click="viewCaching"
                        spinner="viewCaching"
                        loading-delay="long">
                        {{ __('Cache') }}
                    </x-filament::button>
                    <x-filament::button icon="heroicon-m-trash" color="success" wire:click="viewClearing"
                        spinner="viewClearing"
                        loading-delay="long">
                        {{ __('Clear') }}
                    </x-filament::button>
                </div>
            </div>
        </div>
    </div>
</div>
