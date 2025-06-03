<div class="mb-4 sm:mb-0 sm:ml-16 sm:flex-none sm:justify-end">
    <x-button text="Adicionar" wire:click="$toggle('modal')" />
    <x-modal title="Criação de Item" wire>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-input label="Nome" wire:model="item.name" />

            <x-filter.category wire:model="item.category_id" />

            @if (!$description)
                <p class="text-sm text-primary font-semibold cursor-pointer" wire:click="$toggle('description')">Definir descrição do item</p>
            @endif

            @if ($description)
                <div class="col-span-full">
                    <x-textarea label="Descrição"
                                wire:model="item.description"
                                class="resize-none"
                                rows="8"
                    />
                </div>
            @endif

            <div class="col-span-full">
                <x-number label="Quantidade"
                          centralized
                          :min="1"
                          wire:model="item.quantity" />
            </div>

            <div class="col-span-full flex items-center gap-2">
                <x-toggle label="Ativo" lg wire:model="item.is_active" />
                <x-toggle label="Cotas" lg wire:model.live="item.is_quotable" />
            </div>

            @if ($item->is_quotable)
                <div>
                    <x-input type="number"
                             label="Valor"
                             wire:model="item.price"
                    />
                    <p class="mt-1 text-sm font-semibold text-gray-500">valor total, exemplo: 1550 = R$ 15,50</p>
                </div>

                <x-input label="Referência"
                         wire:model="item.reference"
                         placeholder="URL de um item de modelo" />

                @if ($item->price)
                    <div class="col-span-full">
                        <x-alert outline>
                            Valor da Cota: R$ {{ $item->quotePrice() }}
                            <p class="text-xs text-primary font-semibold">(quantidade disponível ({{ $item->availableQuantity() }}) / valor total)</p>
                        </x-alert>
                    </div>
                @endif
            @endif
        </div>
        <x-slot:footer>
            <x-button text="CRIAR" wire:click="create" />
        </x-slot:footer>
    </x-modal>
</div>
