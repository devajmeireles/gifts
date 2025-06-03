@props(['quantity' => null, 'search' => null])

@if ($quantity || $search)
    <div class="mb-4 flex items-end justify-between">
        @if ($quantity)
            <x-native-select
                label="Quantidade"
                :options="[10, 25, 50, 100]"
                wire:model.live.debounce.250ms="quantity"
            />
        @endif
        @if ($search)
            <x-input wire:model.live.debounce.250ms="search"
                     placeholder="Procure por algo..."
                     type="search"
            />
        @endif
    </div>
@endif
