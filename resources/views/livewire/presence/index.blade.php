<div>
    <div class="grid sm:grid-cols-3 mb-4 gap-4">
        <x-presence.card type="confirmed" />
        <x-presence.card type="unconfirmed" />
        <x-presence.card type="conversion" />
    </div>
    @php /** @var \App\Models\Presence $presence */ @endphp
    <div>
        <div class="flex items-end justify-end gap-2">
            @if (!($guest = user()->isGuest()))
                <livewire:presence.create/>
            @endif
            @if ($presences->isNotEmpty())
                <livewire:presence.filter />
            @endif
        </div>
        <x-table.filter quantity search/>
        <div class="mt-4 flow-root">
            <x-table>
                <x-table.thead>
                    <x-table.tr>
                        <x-table.th column="id" :$sort :$direction first label="#"/>
                        <x-table.th column="name" :$sort :$direction label="Nome"/>
                        <x-table.th column="phone" :$sort :$direction label="Telefone"/>
                        <x-table.th label="Assinaturas"/>
                        <x-table.th label="Presença"/>
                        <x-table.th/>
                    </x-table.tr>
                </x-table.thead>
                <x-table.tbody>
                    @forelse ($presences as $presence)
                        <x-table.tr>
                            <x-table.td first>{{ $presence->id }}</x-table.td>
                            <x-table.td>{{ $presence->name }}</x-table.td>
                            <x-table.td>{{ $presence->phone }}</x-table.td>
                            <x-table.td>{{ $presence->signatures_count }}</x-table.td>
                            <x-table.td>
                                <x-badge flat :color="$presence->is_confirmed ? 'green' : 'red'">
                                    {{ $presence->is_confirmed ? 'Confirmada' : 'Não Confirmada' }}
                                </x-badge>
                            </x-table.td>
                            <x-table.td class="inline-flex gap-1" buttons>
                                @if (!$guest)
                                    <x-button.circle primary
                                                     icon="pencil"
                                                     wire:click="update({{ $presence->id }})"
                                    />
                                    <livewire:presence.delete :presence="$presence"
                                                              :key="md5('delete-'.$presence->id)"
                                    />
                                @endif
                            </x-table.td>
                        </x-table.tr>
                    @empty
                        <x-table.empty/>
                    @endforelse
                </x-table.tbody>
            </x-table>
        </div>
        <x-pagination :items="$presences"/>
        @if (!$guest)
            <livewire:presence.update/>
        @endif
    </div>
</div>
