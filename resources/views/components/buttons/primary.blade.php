@isset($link)
    <a
            href="{{ $link }}"
            {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:shadow-md hover:bg-primary-700 focus:outline-none']) }}
    >
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:shadow-md hover:bg-primary-700 focus:outline-none']) }}>
        {{ $slot }}
    </button>
@endisset

{{--@props([--}}
{{--'link' => false--}}
{{--])--}}
{{--<a--}}
{{--        href="{{ $link }}"--}}
{{--        {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:shadow-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-secondary-900 focus:ring-primary-500']) }}--}}
{{-->--}}
{{--    {{ $slot }}--}}
{{--</a>--}}