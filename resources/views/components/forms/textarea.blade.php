<div class="relative">
    <textarea
        name="{{ $name }}"
        id="{{ $id }}"
        rows="{{ $rows }}"
        {{ $attributes->merge([
            'class' =>
                'block w-full mt-1 border-gray-100 bg-gray-100 focus:bg-white hover:bg-white focus:border-primary-300 rounded-lg focus:shadow hover:shadow hover:border-primary-300 focus:ring-0 text-sm sm:text-base sm:leading-5 dark:bg-slate-800 dark:focus:bg-slate-700 dark:hover:bg-slate-700 dark:border-slate-700 dark:focus:border-primary-500 dark:hover:border-primary-500 pr-10' .
                ($errors->has($name)
                    ? ' border-red-300 bg-red-50 dark:bg-red-900 dark:bg-opacity-20 dark:border-red-300 text-red-500 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500'
                    : ''),
        ]) }}>{{ old($name, $slot) }}</textarea>

    @if ($errors->has($name))
        <div class="pointer-events-none absolute top-2 right-0 flex items-center pr-3">
            <x-icons.warning class="h-5 w-5 text-red-500" />
        </div>
    @endif

    @if ($errors->has($name))
        @foreach ($errors->get($name) as $error)
            <x-forms.error>
                {{ $error }}
            </x-forms.error>
        @endforeach
    @endif
</div>
