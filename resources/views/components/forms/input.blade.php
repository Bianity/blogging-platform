<div class="relative">
    @if ($attributes->get('prefix-icon'))
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            @svg($attributes->get('prefix-icon'), ['class' => 'h-5 w-5 text-gray-400'])
        </div>
    @endif

    <input
        name="{{ $name }}"
        type="{{ $type }}"
        {{-- @if ($value) value="{{ $value }}" @endif --}}
        {{ $attributes->merge([
            'class' =>
                'block w-full border-gray-100 rounded-lg bg-gray-100 dark:bg-slate-800 dark:text-slate-400 dark:focus:bg-slate-700 dark:hover:bg-slate-700 dark:border-slate-700 dark:focus:border-primary-500 dark:hover:border-primary-500 focus:bg-white hover:bg-white focus:border-primary-300 focus:shadow hover:shadow hover:border-primary-300 focus:ring-0 focus:ring-offset-0 text-sm sm:text-base sm:leading-5 mt-1 pr-10' .
                ($attributes->get('prefix-icon') ? ' pl-10' : '') .
                ($errors->has($name)
                    ? ' border-red-300 bg-red-50 dark:bg-red-900 dark:bg-opacity-20 dark:border-red-300 text-red-500 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500'
                    : ''),
        ]) }} />

    @if ($errors->has($name))
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
            <x-icons.warning class="h-5 w-5 text-red-500" />
        </div>
    @endif
</div>

@if ($errors->has($name))
    @foreach ($errors->get($name) as $error)
        <x-forms.error>
            {{ $error }}
        </x-forms.error>
    @endforeach
@endif
