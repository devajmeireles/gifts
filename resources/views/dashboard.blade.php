<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="grid grid-cols-3 gap-4">
        <livewire:dashboard.card :type="\App\Enums\Dashboard\CardType::AllItems" />
        <livewire:dashboard.card :type="\App\Enums\Dashboard\CardType::ItemsSigned" />
        <livewire:dashboard.card :type="\App\Enums\Dashboard\CardType::ItemsNotSigned" />
    </div>
    <livewire:dashboard.chart />
</x-app-layout>
