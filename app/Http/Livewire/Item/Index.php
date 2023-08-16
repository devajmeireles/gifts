<?php

namespace App\Http\Livewire\Item;

use App\Http\Livewire\Traits\Table;
use App\Models\Item;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class Index extends Component
{
    use Table;

    protected $listeners = [
        'item::index::refresh' => '$refresh',
    ];

    public function render(): View
    {
        return view('livewire.item.index', [
            'items' => $this->data(),
        ]);
    }

    private function data(): LengthAwarePaginator
    {
        return Item::query()
            ->search($this->search, [
                'name',
                'description',
                'reference',
            ])
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->quantity);
    }

    public function update(Item $item): void
    {
        $this->emitTo(Update::class, 'item::update::load', $item);
    }
}
