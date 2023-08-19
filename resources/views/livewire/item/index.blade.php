<div>
    @php /** @var \App\Models\Item $item */ @endphp
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flow-root">
            <div class="flex justify-end">
                <livewire:item.create />
            </div>
            <x-table.filter quantity search />
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <x-table :$items>
                        <x-table.thead>
                            <x-table.tr>
                                <x-table.th column="id" :$sort :$direction first label="#" />
                                <x-table.th column="name" :$sort :$direction label="Nome" />
                                <x-table.th label="Categoria" />
                                <x-table.th column="quantity" :$sort :$direction label="Quantidade" />
                                <x-table.th label="Status" />
                                <x-table.th />
                            </x-table.tr>
                        </x-table.thead>
                        <x-table.tbody>
                            @forelse ($items as $item)
                                <x-table.tr>
                                    <x-table.td first>{{ $item->id }}</x-table.td>
                                    <x-table.td>{{ $item->name }}</x-table.td>
                                    <x-table.td><x-category.label :model="$item" /></x-table.td>
                                    <x-table.td>{{ $item->quantity }}</x-table.td>
                                    <x-table.td>{{ $item->is_active ? 'Sim' : 'Não' }}</x-table.td>
                                    <x-table.td buttons>
                                        <div class="inline-flex gap-1">
                                            <livewire:item.update :item="$item" :key="md5('update-'.$item->id)" />
                                            <livewire:item.delete :item="$item" :key="md5('delete-'.$item->id)" />
                                        </div>
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.empty />
                            @endforelse
                        </x-table.tbody>
                    </x-table>
                </div>
            </div>
            <x-pagination :$items />
        </div>
    </div>
</div>
