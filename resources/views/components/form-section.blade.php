@props(['submit'])

{{--<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>--}}
<x-section-title>
    <x-slot name="title">{{ $title }}</x-slot>
    <x-slot name="description">{{ $description }}</x-slot>
</x-section-title>

<div>
    <form wire:submit="{{ $submit }}">
        <div class="px-4 py-5 bg-white sm:p-6 {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
            {{ $form }}
        </div>

        @if (isset($actions))
            <div class="flex items-center justify-end px-4 py-6 bg-gray-50 text-right sm:px-6 shadow sm:rounded-br-md">
                {{ $actions }}
            </div>
        @endif
    </form>
</div>
{{--</div>--}}
