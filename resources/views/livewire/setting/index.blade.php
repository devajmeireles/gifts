<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flow-root">
            <x-table.filter quantity search />
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <x-table :items="$settings">
                        <x-table.thead>
                            <x-table.tr>
                                <x-table.th column="key" :$sort :$direction label="Chave" />
                                <x-table.th column="value" :$sort :$direction label="Valor" />
                                <x-table.th />
                            </x-table.tr>
                        </x-table.thead>
                        <x-table.tbody>
                            @forelse ($settings as $setting)
                                <x-table.tr>
                                    <x-table.td>{{ $setting->key }}</x-table.td>
                                    <x-table.td>{{ $setting->value }}</x-table.td>
                                    <x-table.td buttons>
                                        <livewire:setting.update :setting="$setting" :key="$setting->id" />
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.empty />
                            @endforelse
                        </x-table.tbody>
                    </x-table>
                </div>
            </div>
            <x-pagination :items="$settings" />
        </div>
    </div>
</div>
