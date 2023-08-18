<div>
    @php use \App\Enums\DeliveryType; @endphp
    <x-button sm label="Adicionar"
              primary
              wire:click="$toggle('modal')"
    />
    <x-modal.card title="Criação de Assinatura" blur wire:model.defer="modal">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-input label="Nome" wire:model.defer="name"/>

            <x-inputs.maskable label="Telefone"
                               mask="(##) #####-####"
                               wire:model.defer="phone"
            />

            <x-filter.item wire:model.debounce.250ms="selected"/>

            <x-native-select label="Tipo de Entrega"
                             :options="DeliveryType::toSelect()"
                             wire:model.defer="delivery"
                             option-label="label"
                             option-value="id"
            />

            @if ($item && $item->is_quotable)
                <div class="col-span-full">
                    <x-inputs.number label="Quantidade"
                                     wire:model.defer="quantity"
                                     :min="1"
                                     :max="$item->quantity"
                    />
                </div>
            @endif

            <div class="col-span-full">
                <x-textarea label="Observação"
                            wire:model.defer="observation"
                            class="resize-none"
                            rows="8"
                />
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
