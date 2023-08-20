<x-app-layout>
    <div class="grid grid-cols-3 gap-4">
        <livewire:dashboard.card :type="\App\Enums\Dashboard\CardType::AllItems" />
        <livewire:dashboard.card :type="\App\Enums\Dashboard\CardType::AllSignedItems" />
        <livewire:dashboard.card :type="\App\Enums\Dashboard\CardType::AllUnsignedItems" />
    </div>
    <livewire:dashboard.chart />
</x-app-layout>
