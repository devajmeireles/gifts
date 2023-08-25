<div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none sm:justify-end">
    <x-button.circle xs
                     primary
                     icon="pencil"
                     wire:click="$toggle('modal')"
    />
    <x-modal.card :title="__('Edição de Configuração: :name', ['name' => $setting?->key])" wire:model.defer="modal">
        <div class="grid grid-cols-1 gap-4">
            <x-input disabled label="Chave" wire:model.defer="setting.key" />
            @if ($setting->type === 'date')
                <x-datetime-picker label="Valor"
                                   parse-format="YYYY-MM-DD"
                                   wire:model.defer="setting.value"
                                   without-time
                />
            @elseif ($setting->type === 'textarea')
                <x-textarea label="Valor"
                            wire:model.defer="setting.value"
                            class="resize-none"
                />
            @elseif ($setting->type === 'phone')
                <x-inputs.maskable label="Valor"
                                   mask="['(##) ####-####', '(##) #####-####']"
                                   wire:model.defer="setting.value"
                                   :emitFormatted="true"
                />
            @elseif ($setting->type === 'boolean')
                <x-toggle md
                          label="Valor"
                          wire:model.defer="setting.value"
                />
            @else
                <x-input :type="$setting?->type"
                         label="Valor"
                         wire:model.defer="setting.value"
                />
            @endif
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
