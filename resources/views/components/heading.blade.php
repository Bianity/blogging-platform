<div
    {{ $attributes->merge(['class' => 'mb-3 flex items-center justify-between py-4 px-2 sm:flex sm:items-center sm:justify-between sm:px-0']) }}>
    <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-200 sm:text-3xl">
        {{ $title }}</h2>
    @if (isset($action))
        {{ $action }}
    @endif
</div>
