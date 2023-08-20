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

            @if ($item?->is_quotable && $item?->price > 0)
                <div class="col-span-full">
                    <div class="flex justify-center">
                        <p class="text-xs text-red-500 font-semibold">
                            Este item possui um preço definido de R$ {{ $item->price() }}.
                            Ao assinar {{ $quantity }} unidades, o valor total recebido
                            será de R$ {{ $item->price / $item->quantity * $quantity }}
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
                    <x-button primary label="Criar" wire:click="create"/>
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
