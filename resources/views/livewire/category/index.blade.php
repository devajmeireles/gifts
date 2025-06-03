<div>
    <x-card header="Categorias">
        <div class="mb-2">
            @if (!($guest = user()->isGuest()))
                <livewire:category.create @created="$refresh" />
            @endif
        </div>
        <x-table :headers="$this->headers" :rows="$this->rows" filter paginate simple-pagination loading>
            @interact('column_status', $row)
                <x-boolean :boolean="$row->is_active"
                           color-when-true="green"
                           color-when-false="gray" />
            @endinteract
            @interact('column_action', $row)
                <div class="flex gap-1">
                    <x-button.circle icon="pencil"
                                     color="green"
                                     wire:click="$dispatch('category::update::load', { category: '{{ $row->id }}' })" />
                    <livewire:category.delete :category="$row"
                                              :key="uniqid()"
                                              @deleted="$refresh" />
                </div>
            @endinteract
        </x-table>
        @if (!user()->isGuest())
            <livewire:category.update @updated="$refresh" />
        @endif
    </x-card>
</div>
