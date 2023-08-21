<div class="flex justify-end gap-1">
    @php use \App\Enums\DeliveryType; @endphp
    <x-button xs
              primary
              class="w-full"
              label="ASSINAR"
              wire:click="$toggle('modal')"
    />
    <x-modal.card title="Nova Assinatura" wire:model.defer="modal">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="col-span-full">
                <x-input label="Nome"
                         placeholder="Insira seu nome aqui"
                         wire:model.defer="signature.name"
                         autocomplete="name"
                />
            </div>
            <div class="col-span-full">
                <x-inputs.maskable label="Telefone"
                                   mask="(##) #####-####"
                                   placeholder="Insira seu telefone celular aqui"
                                   wire:model.defer="signature.phone"
                                   autocomplete="phone"
                                   :emitFormatted="true"
                />
            </div>
            <x-input label="Item Selecionado"
                     value="{{ $item?->name }}"
                     disabled
            />
            <div class="col-span-1">
                <x-native-select label="Tipo de Entrega"
                                 :options="DeliveryType::toSelect()"
                                 wire:model.debounce.250ms="delivery"
                                 option-label="label"
                                 option-value="id"
                />
                @if ($delivery)
                    <p class="text-sm font-semibold text-primary">{{ DeliveryType::from($delivery)->tip() }}</p>
                @endif
            </div>
            @if ($item && $item->availableQuantity() > 1)
                <div class="col-span-full space-y-2">
                    <x-inputs.number label="Quantidade"
                                     wire:model.debounce.250ms="quantity"
                                     :min="1"
                                     :max="$item->availableQuantity()"
                    />
                    <p class="text-sm font-semibold underline decoration-dotted text-primary">
                        {{ $item->availableQuantity() }} cotas disponíveis
                    </p>
                </div>
            @endif
            @if ($item && $item->is_quotable)
                @php($available = $item->availableQuantity())
                <div class="col-span-full space-y-2">
                    <x-alert outline justify>
                        Ao assinar {{ $quantity }} unidade(s) o valor total que deverá ser entregue
                        como presente será o valor de R$ {{ $item->priceQuoted($quantity, false) }} porque este item possui cotas <b class="underline decoration-dotted">(cotas disponíveis: {{ $available }}).</b>
                    </x-alert>
                </div>
            @endif
            <div class="col-span-full">
                <x-textarea label="Observação"
                            placeholder="Insira uma observação que ache ser necessária aqui"
                            wire:model.defer="signature.observation"
                            class="resize-none"
                            rows="5"
                />
            </div>
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <div class="flex">
                    <x-button flat label="Cancelar" x-on:click="close"/>
                    <x-button primary label="Assinar" wire:click="create"/>
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
