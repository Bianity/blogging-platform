<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <link rel="shortcut icon"
        href="{{ $generalSettings->site_favicon ? Storage::disk(getCurrentDisk())->url($generalSettings->site_favicon) : asset('images/favicon.png') }}"
        type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family={{ config('alma.default_font') }}:wght@400;600;700&display=swap">

    <!-- Styles -->
    @livewireStyles
    <style>
        .font-sans {
            font-family: @php echo config('alma.default_font')
        @endphp
        ,
        sans-serif !important;
        }
    </style>

    <!-- Scripts -->
    <wireui:scripts />
    @vite(['resources/css/app.css', 'resources/css/tagify.css', 'resources/js/tagify.js', 'resources/js/editor.js'])

</head>

<body class="h-full bg-white font-sans antialiased">
    <div class="h-screen overflow-auto">
        <main>
            {{ $slot }}
            <x-notifications z-index="z-50" />
        </main>
    </div>

    @livewireScriptConfig
    @stack('editor-scripts')
</body>

</html>
