<div>
    <x-modal.card :title="__('Edição de Categoria: #:id', ['id' => $category?->id])" blur wire:model.defer="modal">
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-1">
                <x-input label="Nome" wire:model.defer="category.name"/>
            </div>

            <div class="col-span-1">
                <x-select x-searchable
                          label="Cor Destaque"
                          :options="$colors->map(fn ($color) => ['name' => $color->name, 'id' => $color->value])"
                          option-label="name"
                          option-value="id"
                          wire:model.debounce.250ms="color"
                />

                @if ($color)
                    <div>
                        <x-badge outline :$color>Exemplo de Cor</x-badge>
                    </div>
                @endif
            </div>

            <div class="col-span-full">
                <x-textarea label="Descrição"
                            wire:model.defer="category.description"
                            class="resize-none"
                            rows="8"
                />
            </div>

            <div class="col-span-full">
                <x-toggle label="Ativo" lg wire:model.defer="category.is_active"/>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <div class="flex">
                    <x-button flat label="Cancelar" x-on:click="close" />
                    <x-button primary label="Salvar" wire:click="update" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
