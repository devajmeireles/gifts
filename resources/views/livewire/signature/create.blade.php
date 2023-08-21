<div>
    @php use \App\Enums\DeliveryType; @endphp
    <x-button label="Adicionar"
              primary
              wire:click="$toggle('modal')"
    />
    <x-modal.card title="Criação de Assinatura" wire:model.defer="modal">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-input label="Nome" wire:model.defer="signature.name"/>

            <x-inputs.maskable label="Telefone"
                               mask="(##) #####-####"
                               wire:model.defer="signature.phone"
                               :emitFormatted="true"
            />

            <x-filter.item wire:model.debounce.250ms="selected"/>

            <x-native-select label="Tipo de Entrega"
                             :options="DeliveryType::toSelect()"
                             wire:model.defer="delivery"
                             option-label="label"
                             option-value="id"
            />

            @if ($item?->quantity > 1)
                <div class="col-span-full">
                    <x-inputs.number label="Quantidade"
                                     wire:model.debounce.250ms="quantity"
                                     :min="1"
                                     :max="$item->availableQuantity()"
                    />
                </div>
            @endif

            @if ($item && $item->is_quotable && $item->price)
                <div class="col-span-full">
                    <x-alert outline center>
                        <b>Este item possui cotas (R$ {{ $item->price() }}).</b> {{ $quantity }} unidade(s), custará R$ {{ $item->priceQuoted($quantity, false) }}
                    </x-alert>
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
                    <x-button primary label="Criar" wire:click="create"/>
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
