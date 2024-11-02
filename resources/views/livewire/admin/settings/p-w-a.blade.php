<div>
    <form wire:submit="store">
        {{ $this->form }}

        <div class="flex justify-end gap-x-4 px-2 py-5">
            <x-filament::button type="submit" spinner="store"
                loading-delay="long">
                {{ __('Save') }}
            </x-filament::button>
        </div>
    </form>

    <x-filament-actions::modals />
</div>
