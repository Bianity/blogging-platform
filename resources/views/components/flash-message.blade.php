<div x-data="{ open: true }">
    @if ($shown)
        <div x-show="open"
            class="{{ $styles['border-color'] }} {{ $styles['bg-color'] }} flex flex-row rounded-r-md border-l-4">
            @if ($styles['icon'] ?? false)
                <div class="mx-3 flex flex-shrink-0 place-items-center">
                    @if ($styles['icon'] == 'exclamation-circle')
                        <p class="{{ $styles['icon-color'] }}">
                            <x-icon name="{{ $styles['icon'] }}" class="h-8 w-8 text-yellow-500" />
                        </p>
                    @else
                        <p class="{{ $styles['icon-color'] }}">
                            <x-icon name="{{ $styles['icon'] }}" class="h-8 w-8" />
                        </p>
                    @endif
                </div>
            @endif
            <div class="{{ $styles['text-color'] }} flex-1 p-4 text-sm font-medium leading-5">
                {!! $message['message'] !!}
            </div>
            @if ($message['dismissable'] ?? false)
                <div
                    class="flex cursor-pointer place-items-center border-l border-gray-100 px-4 hover:rounded-r-md hover:bg-gray-200"
                    wire:click="dismiss" @click="open = false">
                    <x-icon name="x-circle" class="h-8 w-8 text-gray-400" />
                </div>
            @endif
        </div>
    @endif
</div>
