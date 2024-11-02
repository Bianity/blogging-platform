@props(['active'])

@php
$classes = $active ?? false ? 'flex items-center px-3 py-2.5 ml-1 whitespace-nowrap text-base font-semibold leading-5 text-primary-500' : 'flex items-center px-3 py-2.5 ml-1 whitespace-nowrap text-base font-semibold leading-5 text-secondary-900 dark:text-gray-300';
$text = $active ?? false ? 'ml-3 text-base font-semibold text-primary-500' : 'ml-3 text-base font-semibold';

$li = $active ?? false ? ' my-3 rounded-sm bg-secondary-100 border-r-4 border-primary-400 transition duration-150 ease-in-out dark:bg-gray-700' : ' my-3 rounded-sm hover:bg-secondary-50 border-transparent border-r-4 transition duration-150 ease-in-out dark:hover:bg-gray-700';
@endphp

<li {{ $attributes->merge(['class' => $li]) }}>
    <a {{ $attributes->merge(['class' => $classes]) }}>
        <div class="flex items-center">
            {{ $icon }}
            <span {{ $attributes->merge(['class' => $text]) }}>
                {{ $slot }}
            </span>
        </div>
    </a>
</li>
