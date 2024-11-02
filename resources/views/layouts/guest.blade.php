<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.partials.head')
    @if ($advancedSettings->recaptcha_active !== false)
        <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
    @endif
</head>

<body class="font-inter bg-white text-gray-600 antialiased dark:bg-slate-900 dark:text-gray-300">
    <div>
        {{ $slot }}
    </div>
    @livewireScriptConfig
    @stack('scripts')
</body>

</html>
