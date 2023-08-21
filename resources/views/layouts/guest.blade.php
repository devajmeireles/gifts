@props(['wrap' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @wireUiScripts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans text-gray-900 antialiased">
        @if ($wrap)
            <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">
                <div class="w-full sm:max-w-lg mt-6 px-6 py-6 bg-white shadow-md overflow-hidden rounded-lg">
                    @endif
                        {{ $slot }}
                    @if ($wrap)
                </div>
            </div>
        @endif
        @livewireScripts
    </body>
</html>

