<div>
    <x-modal.card :title="__('Edição de Presença: #:id', ['id' => $presence?->id])" wire:model="modal">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-input label="Nome" wire:model="presence.name"/>

            @if ($presence)
                <x-inputs.maskable label="Telefone"
                                   mask="['(##) #####-####', '(##) ####-####']"
                                   wire:model="presence.phone"
                                   :emitFormatted="true"
                />
            @endif

            @if (!$observation)
                <p class="text-sm text-primary font-semibold cursor-pointer" wire:click="$toggle('observation')">
                    Definir observação da assinatura
                </p>
            @endif

            @if ($observation)
                <div class="col-span-full">
                    <x-textarea label="Observação"
                                wire:model="presence.observation"
                                class="resize-none"
                                rows="8"
                    />
                </div>
            @endif

            <div class="col-span-full flex items-center gap-2">
                <x-toggle label="Presença Confirmada" lg wire:model="presence.is_confirmed"/>
            </div>
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <div class="flex">
                    <x-button flat label="Cancelar" x-on:click="close"/>
                    <x-button primary label="Salvar" wire:click="update"/>
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
