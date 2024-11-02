@props([
'href' => false
])
<a
        href="{{ $href }}"
        {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-md shadow-sm text-white bg-secondary-600 hover:shadow-md hover:bg-secondary-700 active:bg-secondary-900 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150']) }}
>
    {{ $slot }}
</a>