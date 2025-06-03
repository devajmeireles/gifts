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
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
    <body x-bind:class="{ 'dark bg-gray-700': darkTheme, 'bg-gray-100': !darkTheme }">

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
            <x-side-bar smart collapsible>
                <x-side-bar.item :route="route('admin.dashboard')" icon="home" text="Página Inicial" />
                <x-side-bar.item :route="route('admin.items.index')" icon="gift" text="Itens" />
                <x-side-bar.item :route="route('admin.categories')" icon="tag" text="Categorias" />
                <x-side-bar.item :route="route('admin.signatures.index')" icon="pencil" text="Assinaturas" />
                <x-side-bar.item :route="route('admin.presences.index')" icon="user-group" text="Presenças" />
                <x-side-bar.item icon="shield-check" text="Administração" opened>
                    <x-side-bar.item :route="route('admin.users')" icon="users" text="Usuários" :visible="user()->isAdmin()" />
                    <x-side-bar.item :route="route('admin.settings')" icon="cog" text="Configurações" />
                </x-side-bar.item>
            </x-side-bar>
        </x-slot:menu>

        {{ $slot }}
    </x-layout>

    @livewireScripts
    </body>
</html>
