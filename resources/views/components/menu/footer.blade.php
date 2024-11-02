<nav class="px-4 py-2">
    <ul class="flex flex-wrap gap-x-2">
        @foreach ($footerMenu as $page)
            <li>
                <a href="{{ route('page.show', ['page' => $page->slug]) }}"
                    class="text-sm font-medium leading-6 text-gray-600 transition duration-150 ease-in-out hover:text-primary-600 dark:text-slate-400 dark:hover:text-primary-500">
                    {{ $page->title }}
                </a>
            </li>
        @endforeach
        <li><a class="text-sm font-medium leading-6 text-gray-600 transition duration-150 ease-in-out hover:text-primary-600 dark:text-slate-400 dark:hover:text-primary-500"
                href="{{ route('contact-form.show') }}">{{ __('Contact us') }}</a></li>
    </ul>
    <p class="pt-1 text-xs text-gray-600">© {{ \Carbon\Carbon::now()->year }}
        {{ $generalSettings->site_name ?? env('APP_NAME') }}</p>
</nav>
