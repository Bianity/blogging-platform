<div class="my-6 px-3">
    <x-forms.label class="mb-2 text-xs text-gray-500">
        {{ __('Choose if and how you want to show comments') }}
    </x-forms.label>
    <x-select
        searchable="0"
        placeholder="{{ __('Choose comments visibility') }}"
        class="shadow-none"
        wire:model="commentVisibility">
        <x-select.option label="{{ __('Allow all comments') }}" value="Allow" />
        <x-select.option label="{{ __('Allow comments from followers only') }}" value="Followers" />
        <x-select.option label="{{ __('Disable comments') }}" value="Disable" />
    </x-select>
</div>
