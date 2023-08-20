<div>
    @php use \App\Enums\DeliveryType; @endphp
    <x-button.circle xs
                     primary
                     icon="pencil"
                     wire:click="$toggle('modal')"
    />
    <x-modal.card :title="__('Edição de Assinatura: #:id', ['id' => $signature?->id])" blur wire:model.defer="modal">
        <div class="mb-4">
            <x-alert>
                Por mais que seja possível editar uma assinatura, não recomendamos que faça isso.
                Prefira deletar a assinatura e criar novamente como os ajustes necessários.
            </x-alert>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-input label="Nome" wire:model.defer="signature.name"/>

            <x-inputs.maskable label="Telefone"
                               mask="(##) #####-####"
                               wire:model.defer="signature.phone"
            />

            <x-filter.item wire:model.debounce.250ms="selected"/>

            <x-native-select label="Tipo de Entrega"
                             :options="DeliveryType::toSelect()"
                             wire:model.defer="delivery"
                             option-label="label"
                             option-value="id"
            />

            @if ($item && $signature->item->isNot($item))
                <div class="col-span-full">
                    <div class="flex justify-center">
                        <p class="text-xs text-red-500 font-semibold">
                            Ao trocar o item da assinatura, uma única quantidade do
                            novo item será consumido para esta assinatura.
                        </p>
                    </div>
                </div>
            @endif

            <div class="col-span-full">
                <x-textarea label="Observação"
                            wire:model.defer="signature.observation"
                            class="resize-none"
                            rows="8"
                />
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
