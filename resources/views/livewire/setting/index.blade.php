<div>
    <div class="px-4 sm:px-6 lg:px-8">
        @if ($settings->isNotEmpty())
            <x-table.filter quantity search />
        @endif
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
                        <x-table.td>{{ str($setting->value)->limit(30) }}</x-table.td>
                        <x-table.td buttons>
                            <livewire:setting.update :setting="$setting" :key="md5('update-'.$setting->id)" />
                        </x-table.td>
                    </x-table.tr>
                @empty
                    <x-table.empty />
                @endforelse
            </x-table.tbody>
        </x-table>
        <x-pagination :items="$settings" />
    </div>
</div>
