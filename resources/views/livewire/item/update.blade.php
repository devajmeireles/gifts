<div>
    <x-modal.card :title="__('Edição de Item: #:id', ['id' => $item?->id])" blur wire:model.defer="modal">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-input label="Nome" wire:model.defer="item.name" />

            @if ($item)
                <x-select label="Categoria"
                          wire:model.defer="item.category_id"
                          placeholder="Procure uma categoria"
                          :async-data="route('api.category')"
                          option-label="name"
                          option-value="id"
                />
            @endif

            <div class="col-span-full">
                <x-textarea label="Descrição"
                            wire:model.defer="item.description"
                            class="resize-none"
                            rows="8"
                />
            </div>

            <div class="col-span-full">
                <x-input label="Referência" wire:model.defer="item.reference" />
            </div>

            <x-inputs.number label="Quantidade" wire:model.defer="item.quantity" />

            <div class="col-span-1 flex items-center sm:mt-6">
                <x-toggle label="Ativo" lg wire:model.defer="item.is_active" />
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
