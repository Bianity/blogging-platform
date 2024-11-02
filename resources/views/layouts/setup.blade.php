<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <wireui:scripts />
</head>

<body class="bg-slate-100 text-gray-600 antialiased dark:text-gray-300">
    <div class="flex items-center justify-center px-2.5 pt-20 md:px-6">
        <main class="mb-12 mt-6 w-full max-w-xl lg:max-w-2xl">
            <div class="mx-auto mb-5 w-52">
                <img src="{{ asset('images/logo.svg') }}"
                    class="h-24 w-48 text-center"alt="logo" />
            </div>
            @include('components.alert')
            {{ $slot }}
        </main>
    </div>
</body>

</html>
