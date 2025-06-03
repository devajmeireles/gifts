<div>
    <div>
        <div class="flex items-end justify-end gap-2">
            @if (!($guest = user()->isGuest()))
                <livewire:item.create @created="$refresh" />
            @endif
            @if ($this->rows->isNotEmpty())
                <livewire:item.filter />
            @endif
        </div>
        <x-table :headers="$this->headers" :rows="$this->rows" paginate simple-pagination loading />
{{--        @if (!user()->isGuest())--}}
{{--            <livewire:item.update />--}}
{{--            <livewire:item.delete />--}}
{{--        @endif--}}
    </div>
</div>
