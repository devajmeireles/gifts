<div>
    @php /** @var \App\Models\Item $category */ @endphp
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-end">
            @if (!user()->isGuest())
                <livewire:category.create />
            @endif
        </div>
        @if ($categories->isNotEmpty())
            <x-table.filter quantity search />
        @endif
        <div class="mt-4 flow-root">
            <x-table :items="$categories">
                <x-table.thead>
                    <x-table.tr>
                        <x-table.th column="id" :$sort :$direction first label="#" />
                        <x-table.th column="name" :$sort :$direction label="Nome" />
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
                            <x-table.td>
                                <x-status :status="$category->is_active" />
                            </x-table.td>
                            <x-table.td buttons>
                                <x-button.circle primary
                                                 icon="pencil"
                                                 wire:click="update({{ $category->id }})"
                                />
                                <x-button.circle primary
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
            <x-pagination :$items="$categories" />
        </div>
        @if (!user()->isGuest())
            <livewire:category.update />
            <livewire:category.delete />
        @endif
    </div>
</div>
