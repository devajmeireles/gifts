<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      class="h-full bg-gray-100"
      x-data="{ mobile : false }"
      x-cloak
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    @wireUiScripts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
    <body class="font-sans antialiased h-full">
        <x-layout.navigation />
        <x-dialog />
        <x-notifications />
        <div class="min-h-full">
            <div class="lg:pl-72">
                <x-layout.header />
                <main class="max-w-full mx-auto sm:px-6 lg:px-8 py-10">
                    <div class="px-4 sm:px-6 lg:px-8">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
        @livewireScripts
    </body>
</html>
