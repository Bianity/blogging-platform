@props(['limit' => 255, 'value' => ''])

<div
    x-data="{
        content: '{{ $value }}',
        limit: {{ $limit }},
        get remaining() {
            return this.limit - this.content.length
        }
    }">
    <small x-cloak class="block" :class="{ 'hidden': remaining > 20 }">
        <span x-text="remaining"
            class="rounded-md py-0.5 px-1 font-bold shadow-sm"
            :class="{ 'bg-primary-50 flex': remaining > 20, 'bg-red-50 text-red-500': remaining <= 20 }"></span>
        {{ __('characters remaining') }}
    </small>
    <textarea
        x-model="content"
        maxlength="{{ $limit }}"
        {{ $attributes }}></textarea>
</div>
