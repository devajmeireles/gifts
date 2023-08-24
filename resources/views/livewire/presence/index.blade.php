<div>
    <div class="grid grid-cols-3 mb-4">
        <div class="col-span-1">
            <x-card>
                Confirmados
            </x-card>
        </div>
        <div class="col-span-1">
            <x-card>
                Não Confirmados
            </x-card>
        </div>
        <div class="col-span-1">
            <x-card>
                Percentual Confirmado
            </x-card>
        </div>
    </div>
    @php /** @var \App\Models\Presence $presence */ @endphp
    <div>
        <div class="flex items-end justify-end gap-2">
            @if (!($guest = user()->isGuest()))
                <livewire:presence.create />
            @endif
{{--            @if ($items->isNotEmpty())--}}
{{--                <livewire:item.filter />--}}
{{--            @endif--}}
        </div>
        <x-table.filter quantity search />
        <div class="mt-4 flow-root">
            <x-table>
                <x-table.thead>
                    <x-table.tr>
                        <x-table.th column="id" :$sort :$direction first label="#" />
                        <x-table.th column="name" :$sort :$direction label="Nome" />
                        <x-table.th column="phone" :$sort :$direction label="Telefone" />
                        <x-table.th label="Assinaturas" />
                        <x-table.th label="Presença" />
                        <x-table.th />
                    </x-table.tr>
                </x-table.thead>
                <x-table.tbody>
                    @forelse ($presences as $presence)
                        <x-table.tr>
                            <x-table.td first>{{ $presence->id }}</x-table.td>
                            <x-table.td>{{ $presence->name }}</x-table.td>
                            <x-table.td>{{ $presence->phone }}</x-table.td>
                            <x-table.td>{{ $presence->signatures?->count() }}</x-table.td>
                            <x-table.td>
                                <x-badge flat :color="$presence->is_confirmed ? 'green' : 'red'">
                                    {{ $presence->is_confirmed ? 'Confirmada' : 'Não Confirmada' }}
                                </x-badge>
                            </x-table.td>
                            <x-table.td buttons>
                                <x-button.circle primary
                                                 icon="pencil"
                                                 wire:click="update({{ $presence->id }})"
                                />
                                <livewire:presence.delete :presence="$presence" :key="md5('presence-'.$presence->id)" />
                            </x-table.td>
                        </x-table.tr>
                    @empty
                        <x-table.empty />
                    @endforelse
                </x-table.tbody>
            </x-table>
        </div>
        <x-pagination :items="$presences" />
{{--        @if (!user()->isGuest())--}}
{{--            <livewire:item.update />--}}
{{--            <livewire:item.delete />--}}
{{--        @endif--}}
    </div>
</div>
