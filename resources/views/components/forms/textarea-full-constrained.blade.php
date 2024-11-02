@props(['limit' => 2000, 'value' => ''])

<div
    class="relative"
    x-data="{
        content: '{{ $value }}',
        limit: {{ $limit }},
        get remaining() {
            return this.limit - this.content.length
        }
    }">
    <x-forms.textarea
        x-model="content"
        maxlength="{{ $limit }}"
        {{ $attributes }}>
    </x-forms.textarea>
    <small x-cloak class="mt-2 block" :class="{ 'hidden': remaining > 30 }">
        <span x-text="remaining"
            class="rounded-md py-0.5 px-1 font-bold shadow-sm"
            :class="{ 'bg-primary-50 flex': remaining > 30, 'bg-red-50 text-red-500': remaining <= 30 }"></span>
        {{ __('characters remaining') }}
    </small>
</div>
