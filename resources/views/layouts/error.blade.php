<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-inter h-full bg-primary_light text-gray-600 antialiased dark:bg-primary_black dark:text-gray-300">
    <div class="flex h-screen w-screen items-center justify-center bg-gradient-to-r from-indigo-600 to-blue-400">
        <div class="rounded-md bg-white px-40 py-20 shadow-xl">
            <div class="flex flex-col items-center">
                <h1 class="text-9xl font-bold text-blue-600">{{ $errorCode }}</h1>

                <h6 class="mb-2 text-center text-2xl font-bold text-gray-800 md:text-3xl">
                    @isset($errorTitle)
                        {{ $errorTitle }}
                    @else
                        {{ __('Hello, is it me you\'re looking for?') }}
                    @endisset
                </h6>

                <p class="mb-8 text-center text-gray-500 md:text-lg">
                    @isset($errorMsg)
                        {{ $errorMsg }}
                    @else
                        {{ __('The page you\'re looking for doesn\'t exist.') }}
                    @endisset
                </p>
                @if ($homeLink ?? false)
                    <x-buttons.primary :link="route('home')">
                        {{ __('Go Back Home') }}
                    </x-buttons.primary>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
