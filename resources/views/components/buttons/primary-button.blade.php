@props(['fullWidth' => false])

@if ($attributes->has('href'))
    <a
        {{ $attributes->merge([
            'class' =>
                ($fullWidth ? 'w-full ' : '') .
                'inline-flex justify-center items-center rounded-lg border border-transparent bg-primary-500 px-2 py-1.5 text-sm sm:px-4 sm:text-base font-semibold text-white shadow transition duration-300 ease-in-out hover:shadow-md hover:bg-primary-600 focus:outline-none',
        ]) }}>
        {{ $slot }}
    </a>
@else
    <button
        {{ $attributes->merge([
            'type' => 'submit',
            'class' =>
                ($fullWidth ? 'w-full ' : '') .
                'inline-flex justify-center items-center rounded-lg border border-transparent bg-primary-500 px-2 py-1.5 text-sm sm:px-4 sm:text-base font-semibold text-white shadow transition duration-300 ease-in-out hover:shadow-md hover:bg-primary-600 focus:outline-none',
        ]) }}>
        {{ $slot }}
    </button>
@endif
