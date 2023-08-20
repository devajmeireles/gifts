<div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none sm:justify-end">
    <x-button.circle xs
                     primary
                     icon="pencil"
                     wire:click="$toggle('modal')"
    />
    <x-modal.card :title="__('Edição de Configuração: :name', ['name' => $setting?->key])" wire:model.defer="modal">
        <div class="grid grid-cols-1 gap-4">
            <x-input disabled label="Chave" wire:model.defer="setting.key" />
            <x-input label="Valor" wire:model.defer="setting.value" />
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
