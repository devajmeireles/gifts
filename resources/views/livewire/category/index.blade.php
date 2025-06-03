<div>
    <div>
        <div class="flex items-end justify-end">
            @if (!($guest = user()->isGuest()))
                <livewire:category.create @created="$refresh" />
            @endif
        </div>
{{--        <x-table.filter quantity search />--}}
        <x-table :headers="$this->headers" :rows="$this->rows" paginate simple-pagination loading>
            @interact('column_status', $row)
                <x-boolean :boolean="$row->is_active"
                           color-when-true="green"
                           color-when-false="gray" />
            @endinteract
        </x-table>
{{--        @if (!user()->isGuest())--}}
{{--            <livewire:category.update />--}}
{{--            <livewire:category.delete />--}}
{{--        @endif--}}
    </div>
</div>
