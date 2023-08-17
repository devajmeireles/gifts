@props([
    'items',
    'quantity' => null,
    'search'   => null,
])

<div @class(['mt-4' => !$quantity && !$search])>
    @if ($quantity || $search)
        <div class="mb-4 flex items-end justify-between">
            @if ($quantity)
                <x-native-select
                    label="Quantidade"
                    :options="[10, 25, 50, 100]"
                    wire:model.debounce.250ms="quantity"
                />
            @endif
            @if ($search)
                <x-input wire:model.debounce.250ms="search"
                         placeholder="Procure por algo..."
                         type="search"
                />
            @endif
        </div>
    @endif
    <div class="overflow-auto shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-300">
            {{ $slot }}
        </table>
        @if ($items->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</div>
