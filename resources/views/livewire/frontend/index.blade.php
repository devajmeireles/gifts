<div wire:init="category">
    <div class="justify-center" wire:loading.flex wire:target="category">
        <x-preloader />
    </div>
    <div class="justify-center" wire:loading.flex wire:target="item">
        <x-preloader />
    </div>
    @if (!$filtered && $data)
        <div wire:loading.remove wire:target="item" class="grid grid-cols-3 gap-4" wire:key="category">
            @php /** @var \App\Models\Category $category */ @endphp
            @forelse ($data as $category)
                <div class="col-span-1">
                    <x-card>
                        <div @class(['p-4', 'cursor-pointer' => $category->items_count > 0]) @if ($category->items_count > 0) wire:click="item({{ $category->id }})" @endif>
                            <p class="text-2xl font-semibold uppercase text-primary">
                                {{ $category->name }}
                            </p>
                            <p class="text-sm leading-6 text-gray-600">
                                {{ trans_choice(
                                    '{0} Nenhum item nesta categoria|{1} 1 item nesta categoria|[2,*] :count itens nesta categoria',
                                    $category->items_count ?? 0, [
                                        'count' => $category->items_count ?? 0
                                ]) }}
                            </p>
                        </div>
                    </x-card>
                </div>
            @empty
                <div class="col-span-full">
                    <x-empty-card text="Ainda não há nenhuma categoria de presente. Volte daqui a pouco! 😉"/>
                </div>
            @endforelse
        </div>
    @endif
    @if ($filtered && $data)
        <div class="flex items-center gap-2">
            <p class="text-4xl text-primary font-bold uppercase">
                {{ $category->name }}
            </p>
            @if ($category->description)
                <p class="text-md text-gray-600">{{ $category->description }}</p>
            @endif
        </div>
        <div class="mt-2">
            <x-input wire:model.debounce.500ms="search"
                     placeholder="Procure por algo..."
                     type="search"
            />
        </div>
        <div wire:loading.remove wire:target="category" class="grid grid-cols-3 gap-4 mt-4" wire:key="item">
            @php /** @var \App\Models\Item $item */ @endphp
            @forelse ($data as $item)
                <div class="col-span-1">
                    <x-card>
                        <div class="p-4">
                            <p class="text-2xl font-semibold uppercase text-primary">
                                {{ $item->name }}
                            </p>
                            <p class="text-sm leading-6 text-gray-600">
                                {!! trans_choice(
                                    '{1} 1 unidade disponível :quota|[2,*] :count unidades disponíveis :quota',
                                    $item->availableQuantity(), [
                                        'count' => $item->availableQuantity(),
                                        'quota' => $item->is_quotable ? '<b class="text-primary">(cotas)</b>' : '',
                                ]) !!}
                            </p>
                        </div>
                        <livewire:frontend.signature :item="$item" :key="md5('signature-'.$item->id)" />
                    </x-card>
                </div>
            @empty
                <div class="col-span-full">
                    <x-empty-card text="Ops! Não encontramos o item que você está procurando. 😢"/>
                </div>
            @endforelse
        </div>
        <div class="flex justify-start mt-4">
            <x-button wire:loading.remove
                      wire:target="category"
                      sm
                      primary
                      label="Voltar"
                      icon="arrow-left"
                      wire:click="category"
            />
        </div>
    @endif
</div>
