@props(['fullWidth' => false])

@if ($attributes->has('href'))
    <a
        {{ $attributes->merge([
            'class' =>
                ($fullWidth ? 'w-full ' : '') .
                'inline-flex justify-center items-center rounded-lg border border-transparent bg-white px-2 py-1.5 text-sm sm:px-4 sm:text-base font-medium text-gray-900 shadow transition duration-300 ease-in-out hover:shadow-md 
                                                    dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white focus:outline-none',
        ]) }}>
        {{ $slot }}
    </a>
@else
    <button
        {{ $attributes->merge([
            'type' => 'submit',
            'class' =>
                ($fullWidth ? 'w-full ' : '') .
                'inline-flex justify-center items-center rounded-lg border border-transparent bg-white px-2 py-1.5 text-sm sm:px-4 sm:text-base font-medium text-gray-900 shadow transition duration-300 ease-in-out hover:shadow-md 
                                                    dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white focus:outline-none',
        ]) }}>
        {{ $slot }}
    </button>
@endif
