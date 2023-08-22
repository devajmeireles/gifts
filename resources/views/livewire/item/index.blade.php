<div>
    @php /** @var \App\Models\Item $item */ @endphp
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-end gap-2">
            @if (!($guest = user()->isGuest()))
                <livewire:item.create />
            @endif
            @if ($items->isNotEmpty())
                <livewire:item.filter />
            @endif
        </div>
        <x-table.filter quantity search />
        <div class="mt-4 flow-root">
            <x-table :$items>
                <x-table.thead>
                    <x-table.tr>
                        <x-table.th column="id" :$sort :$direction first label="#" />
                        <x-table.th column="name" :$sort :$direction label="Nome" />
                        <x-table.th label="Categoria" />
                        <x-table.th column="quantity" :$sort :$direction label="Quantidade" />
                        <x-table.th label="Qnt. Assinado" />
                        <x-table.th label="Status" />
                        <x-table.th />
                    </x-table.tr>
                </x-table.thead>
                <x-table.tbody>
                    @forelse ($items as $item)
                        <x-table.tr>
                            <x-table.td first>{{ $item->id }}</x-table.td>
                            <x-table.td :class="!$item->signed() ?: 'line-through'">
                                {{ $item->name }}
                            </x-table.td>
                            <x-table.td><x-category.label :model="$item" /></x-table.td>
                            <x-table.td>{{ $item->availableQuantity() }}</x-table.td>
                            <x-table.td>{{ $item->signatures_count }}</x-table.td>
                            <x-table.td>
                                <x-status :status="$item->is_active" />
                            </x-table.td>
                            <x-table.td buttons>
                                @if (!$guest)
                                    <x-button.circle primary
                                                     icon="pencil"
                                                     wire:click="update({{ $item->id }})"
                                    />
                                    <x-button.circle primary
                                                     icon="trash"
                                                     wire:click="delete({{ $item->id }})"
                                    />
                                @endif
                            </x-table.td>
                        </x-table.tr>
                    @empty
                        <x-table.empty />
                    @endforelse
                </x-table.tbody>
            </x-table>
        </div>
        <x-pagination :$items />
        @if (!user()->isGuest())
            <livewire:item.update />
            <livewire:item.delete />
        @endif
    </div>
</div>
