@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'flex items-center px-2.5 py-2 transition duration-150 truncate whitespace-nowrap text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
                : 'flex items-center px-2.5 py-2 transition duration-150 truncate whitespace-nowrap text-sm font-medium leading-5 text-gray-500 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
    $text = ($active ?? false)
                ? 'text-base font-medium text-blue-500'
                : 'text-base font-medium text-gray-300 hover:text-gray-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <span {{ $attributes->merge(['class' => $text]) }}>
        {{ $slot }}
    </span>
</a>
