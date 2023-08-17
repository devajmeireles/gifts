<div>
    @php /** @var \App\Models\Item $category */ @endphp
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between">
            <x-native-select
                label="Quantidade"
                :options="[10, 25, 50, 100]"
                wire:model.debounce.250ms="quantity"
            />
            <livewire:category.create />
        </div>
        <div class="mt-4 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <x-table :items="$categories">
                        <x-table.thead>
                            <x-table.tr>
                                <x-table.th first label="#" />
                                <x-table.th label="Nome" />
                                <x-table.th label="Qnt. de Itens" />
                                <x-table.th label="Status" />
                                <x-table.th />
                            </x-table.tr>
                        </x-table.thead>
                        <x-table.tbody>
                            @forelse ($categories as $category)
                                <x-table.tr>
                                    <x-table.td first>{{ $category->id }}</x-table.td>
                                    <x-table.td><x-category.label :model="$category" /></x-table.td>
                                    <x-table.td>{{ $category->items_count }}</x-table.td>
                                    <x-table.td>{{ $category->is_active ? 'Sim' : 'Não' }}</x-table.td>
                                    <x-table.td buttons>
                                        <x-button.circle primary
                                                         icon="pencil"
                                                         wire:click="update({{ $category->id }})"
                                        />
                                        <x-button.circle negative
                                                         icon="trash"
                                                         wire:click="delete({{ $category->id }})"
                                        />
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.empty />
                            @endforelse
                        </x-table.tbody>
                    </x-table>
                </div>
            </div>
        </div>
        <livewire:category.update />
        <livewire:category.delete />
    </div>
</div>
