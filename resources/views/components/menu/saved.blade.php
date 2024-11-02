<nav wire:ignore
    class="shadow-xs mb-5 flex items-center overflow-x-auto bg-white px-4 text-lg font-medium dark:bg-slate-800 dark:text-slate-200 md:rounded-lg">
    <a href="{{ route('saved.stories') }}"
        class="{{ request()->routeIs('saved.stories') ? 'nav-active-link' : '' }} hover:text-primary-500 focus:text-primary-600 dark:text-secondary-200 whitespace-nowrap border-b-2 border-transparent px-4 py-5 text-gray-700 focus:outline-none">
        {{ __('Stories') }}
    </a>
    <a href="{{ route('saved.comments') }}"
        class="{{ request()->routeIs('saved.comments') ? 'nav-active-link' : '' }} hover:text-primary-500 focus:text-primary-600 dark:text-secondary-200 whitespace-nowrap border-b-2 border-transparent px-4 py-5 text-gray-700 focus:outline-none">
        {{ __('Comments') }}
    </a>
</nav>
