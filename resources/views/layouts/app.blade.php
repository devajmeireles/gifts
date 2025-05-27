<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="tallstackui_darkTheme()">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <tallstackui:script />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
    <body x-bind:class="{ 'dark bg-gray-700': darkTheme, 'bg-white': !darkTheme }">

    <x-layout>
        <x-slot:header>
            <x-layout.header>
                <x-slot:left>
                    <x-theme-switch />
                </x-slot:left>
                <x-slot:right>
                    <x-dropdown text="Hello, {{ auth()->user()->name }}!">
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <x-dropdown.items text="Logout" onclick="event.preventDefault(); this.closest('form').submit();" />
                        </form>
                    </x-dropdown>
                </x-slot:right>
            </x-layout.header>
        </x-slot:header>

        <x-slot:menu>
            <x-side-bar>
                <x-side-bar.item text="Home" icon="home" :route="route('admin.dashboard')" />
            </x-side-bar>
        </x-slot:menu>

        {{ $slot }}
    </x-layout>

    @livewireScripts
    </body>
</html>
