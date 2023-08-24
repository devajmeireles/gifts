<div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none sm:justify-end">
    <x-button label="Adicionar"
              primary
              wire:click="$toggle('modal')"
    />
    <x-modal.card title="Criação de Presença" wire:model.defer="modal">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-input label="Nome" wire:model.defer="presence.name"/>

            <x-inputs.maskable label="Telefone"
                               mask="['(##) #####-####', '(##) ####-####']"
                               wire:model.defer="presence.phone"
                               :emitFormatted="true"
            />

            @if (!$observation)
                <p class="text-sm text-primary font-semibold cursor-pointer" wire:click="$toggle('observation')">
                    Definir observação da assinatura
                </p>
            @endif

            @if ($observation)
                <div class="col-span-full">
                    <x-textarea label="Observação"
                                wire:model.defer="presence.observation"
                                class="resize-none"
                                rows="8"
                    />
                </div>
            @endif

            <div class="col-span-full flex items-center gap-2">
                <x-toggle label="Presença Confirmada" lg wire:model.defer="presence.is_confirmed"/>
            </div>
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <div class="flex">
                    <x-button flat label="Cancelar" x-on:click="close"/>
                    <x-button primary label="Criar" wire:click="create"/>
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
