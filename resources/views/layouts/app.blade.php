<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.partials.head')
</head>

<body class="h-full bg-slate-100 font-sans antialiased dark:bg-slate-900" x-data="{ sidebarOpen: false }">
    @if ((new \Jenssegers\Agent\Agent())->isMobile())
        @include('layouts.partials.sidebar')
    @endif
    @if ($advancedSettings->banner_after_content !== '')
        <section>{!! $advancedSettings->banner_above_header !!}</section>
    @endif
    @include('components.alert')
    @include('layouts.partials.header')
    <main class="pb-16 sm:pb-0">
        {{ $slot }}
        @include('cookie-consent::index')
    </main>
    @if ((new \Jenssegers\Agent\Agent())->isMobile())
        @include('layouts.partials.mobilebar')
    @endif
    @livewireScriptConfig
    @stack('scripts')
    @stack('styles')
    @if ($advancedSettings->adsense_client_id !== '')
        <script data-ad-client="{{ $advancedSettings->adsense_client_id }}" async
            src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    @endif
    @if ($advancedSettings->custom_footer_code !== '')
        {!! $advancedSettings->custom_footer_code !!}
    @endif
    <x-notifications z-index="z-50" />
    <div class="mb-32">
        <x-dialog z-index="z-50" blur="md" align="center" />
    </div>
</body>

</html>
