@props(['limit' => 50, 'value' => ''])

<div
    class="relative"
    x-data="{
        content: '{{ $value }}',
        limit: {{ $limit }},
        get remaining() {
            return this.limit - this.content.length
        }
    }">
    <x-forms.input
        x-model="content"
        maxlength="{{ $limit }}"
        {{ $attributes }}>
    </x-forms.input>
    <small x-cloak class="mt-2 block" :class="{ 'hidden': remaining > 20 }">
        <span x-text="remaining"
            class="rounded-md py-0.5 px-1 font-bold shadow-sm"
            :class="{ 'bg-primary-50 flex': remaining > 20, 'bg-red-50 text-red-500': remaining <= 20 }"></span>
        {{ __('characters remaining') }}
    </small>
</div>
