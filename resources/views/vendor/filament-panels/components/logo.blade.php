<a class="block h-10 max-w-[160px]" href="{{ route('filament.cp.pages.dashboard') }}" x-cloak>
    @if (!empty($generalSettings->site_logo) && !empty($generalSettings->site_logo_dark))
        <img src="{{ Storage::disk(getCurrentDisk())->url($generalSettings->site_logo) }}"
            class="h-full w-full object-cover"
            :class="{ 'hidden': $store.theme === 'dark' }"
            {{ $attributes }} alt="logo" />
        <img src="{{ Storage::disk(getCurrentDisk())->url($generalSettings->site_logo_dark) }}"
            class="h-full w-full object-cover"
            :class="{ 'hidden': $store.theme === 'light' }"
            {{ $attributes }} alt="logo" />
    @else
        <img src="{{ asset('images/logo.svg') }}"
            class="h-full w-full object-cover"
            :class="{ 'hidden': $store.theme === 'dark' }"
            {{ $attributes }} alt="logo" />
        <img src="{{ asset('images/logo-dark.svg') }}"
            class="h-full w-full object-cover"
            :class="{ 'hidden': $store.theme === 'light' }"
            {{ $attributes }} alt="logo" />
    @endif
</a>
