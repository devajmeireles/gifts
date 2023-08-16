<div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none sm:justify-end">
    <x-button label="Adicionar"
              primary
              wire:click="$toggle('modal')"
    />
    <x-modal.card title="Criação de Categoria" blur wire:model.defer="modal">
        <div class="grid grid-cols-1 gap-4">
            <x-input label="Nome" wire:model.defer="category.name" />

            <x-textarea label="Descrição"
                        wire:model.defer="category.description"
                        class="resize-none"
                        rows="8"
            />

            <x-toggle label="Ativo" lg wire:model.defer="category.is_active" />
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <div class="flex">
                    <x-button flat label="Cancelar" x-on:click="close" />
                    <x-button primary label="Criar" wire:click="create" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
