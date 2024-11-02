@props(['fullWidth' => false])

@if ($attributes->has('href'))
    <a
        {{ $attributes->merge([
            'class' =>
                ($fullWidth ? 'w-full ' : '') .
                'inline-flex justify-center items-center rounded-lg border border-transparent bg-gray-200 px-2 py-1.5 text-sm sm:px-4 sm:text-base font-semibold text-gray-900 shadow transition duration-300 ease-in-out hover:shadow-md hover:bg-gray-300 focus:outline-none dark:bg-slate-600 dark:hover:bg-slate-700 dark:text-white',
        ]) }}>
        {{ $slot }}
    </a>
@else
    <button
        {{ $attributes->merge([
            'type' => 'submit',
            'class' =>
                ($fullWidth ? 'w-full ' : '') .
                'inline-flex justify-center items-center rounded-lg border border-transparent bg-gray-200 px-2 py-1.5 text-sm sm:px-4 sm:text-base font-semibold text-gray-900 shadow transition duration-300 ease-in-out hover:shadow-md hover:bg-gray-300 focus:outline-none dark:bg-slate-600 dark:hover:bg-slate-700 dark:text-white',
        ]) }}>
        {{ $slot }}
    </button>
@endif
