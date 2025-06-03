<div>
    <x-modal :title="__('Edição de Categoria: #:id', ['id' => $category?->id])" wire>
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-1">
                <x-input label="Nome *" wire:model="category.name"/>
            </div>

            <div class="col-span-1">
                <x-select.native label="Cor Destaque"
                                 :options="$colors->map(fn ($color) => ['label' => $color->name, 'value' => $color->value])"
                                 wire:model.live="color" />

                @if ($colors->contains('value', $color))
                    <div class="mt-2">
                        <x-badge :$color>Exemplo de Cor</x-badge>
                    </div>
                @endif
            </div>

            <div class="col-span-full">
                <x-textarea label="Descrição"
                            wire:model="category.description"
                            class="resize-none"
                            rows="8" />
            </div>

            <div class="col-span-full">
                <x-toggle label="Ativo" lg wire:model="category.is_active"/>
            </div>
        </div>

        <x-slot:footer>
            <x-button text="SALVAR" wire:click="update" loading />
        </x-slot:footer>
    </x-modal>
</div>
