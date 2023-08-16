<div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none sm:justify-end">
    <x-button label="Adicionar"
              primary
              wire:click="$toggle('modal')"
    />
    <x-modal.card title="Criação de Item" blur wire:model.defer="modal">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-input label="Nome" wire:model.defer="item.name" />

            <x-input label="Phone" placeholder="USA phone" />

            <div class="col-span-full">
                <x-textarea label="Descrição"
                            wire:model.defer="item.description"
                            class="resize-none"
                            rows="8"
                />
            </div>

            <x-inputs.number label="Quantidade" wire:model.defer="item.quantity" />

            <div class="col-span-1 flex items-center sm:mt-6">
                <x-toggle label="Ativo" lg wire:model.defer="item.is_active" />
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <div class="flex">
                    <x-button flat label="Cancelar" x-on:click="close" />
                    <x-button primary label="Criar" wire:click="create" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
