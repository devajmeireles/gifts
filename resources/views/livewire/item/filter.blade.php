<div>
    <div>
        <x-button.circle xs primary wire:click="$toggle('modal')">
            <x-heroicon-s-funnel class="h-4 w-4" />
        </x-button.circle>
        @if ($filtered)
            <x-badge flat>
                {{ $count }} filtro
                <x-heroicon-s-x-circle wire:click="clear"
                                       class="h-4 w-4 cursor-pointer text-red-500" />
            </x-badge>
        @endif
    </div>
    <x-modal.card title="Filtros & Exportação" wire:model.defer="modal" max-width="lg">
        <div class="grid grid-cols-1 gap-4">
            <x-filter.category wire:model.debounce.250ms="category"/>

            <x-export wire:click="export" />
        </div>
        <hr>
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <div class="flex gap-2">
                    <x-button flat label="Cancelar" x-on:click="close"/>
                    <x-button primary label="Filtrar" wire:click="filter"/>
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
