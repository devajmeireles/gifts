<div wire:init="category">
    <div class="justify-center" wire:loading.flex wire:target="category">
        <x-preloader/>
    </div>
    <div class="justify-center" wire:loading.flex wire:target="item">
        <x-preloader/>
    </div>
    <div class="justify-center" wire:loading.flex wire:target="more">
        <x-preloader overlay/>
    </div>
    @if (!$filtered && $data)
        <div wire:key="category"
             wire:loading.remove
             wire:target="item"
             class="grid grid-cols-2 gap-4 sm:grid-cols-3"
        >
            @php /** @var \App\Models\Category $category */ @endphp
            @forelse ($data as $category)
                <div class="col-span-full sm:col-span-1" id="{{ uniqid() }}">
                    <x-card>
                        <div
                            @class(['p-4', 'cursor-pointer' => $category->items_count > 0]) @if ($category->items_count > 0) wire:click="item({{ $category->id }})" @endif>
                            <p class="text-2xl font-semibold uppercase text-primary">
                                {{ $category->name }}
                            </p>
                            <p class="text-sm leading-6 text-gray-600">
                                {{ trans_choice(
                                    '{0} Nenhum item nesta categoria|{1} 1 item|[2,*] :count itens',
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
            <p class="text-4xl font-bold uppercase text-primary">
                {{ $category->name }}
            </p>
            @if ($category->description)
                <p class="text-gray-600 text-md">{{ $category->description }}</p>
            @endif
        </div>
        <div class="mt-2">
            <x-input wire:model.debounce.500ms="search"
                     placeholder="Procure por algum item..."
                     type="search"
            />
        </div>
        <div wire:key="item"
             wire:loading.remove
             wire:target="category"
             class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3"
        >
            @php /** @var \App\Models\Item $item */ @endphp
            @forelse ($data as $item)
                <div class="col-span-1" id="{{ uniqid() }}">
                    <x-card>
                        <div class="p-4">
                            <p class="text-2xl font-semibold uppercase text-primary">
                                {{ $item->name }}
                                @if ($item->description)
                                    <x-tooltip :text="$item->description"/>
                                @endif
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
                        <livewire:frontend.signature :item="$item" :key="md5('signature-'.$item->id)"/>
                    </x-card>
                </div>
            @empty
                <div class="col-span-full">
                    <x-empty-card text="Ops! Não encontramos o item que você está procurando. 😢"/>
                </div>
            @endforelse
        </div>
        <div class="mt-4 flex justify-start gap-2">
            <div class="space-x-2">
                <x-frontend.float-button primary
                                         wire:loading.remove
                                         wire:target="category"
                                         wire:click="category"
                />
                @if ($data->isNotEmpty())
                    <x-frontend.float-button green
                                             wire:loading.remove
                                             wire:target="category"
                                             wire:click="more"
                    />
                @endif
            </div>
        </div>
    @endif
</div>
