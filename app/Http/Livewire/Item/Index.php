<?php

namespace App\Http\Livewire\Item;

use App\Filters\Item\FilterCategoryItem;
use App\Http\Livewire\Traits\Table;
use App\Models\Item;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Pipeline;
use Livewire\Component;

class Index extends Component
{
    use Table;

    protected $listeners = [
        'item::index::refresh' => '$refresh',
        'item::index::filter'  => 'filter',
    ];

    private array $filters = [];

    public function render(): View
    {
        return view('livewire.item.index', [
            'items' => $this->data(),
        ]);
    }

    public function filter(array $filters): void
    {
        $this->filters = [...$filters];
    }

    private function data(): LengthAwarePaginator
    {
        $items = Item::with(['category', 'signatures'])
            ->withCount('signatures');

        return Pipeline::send($items)
            ->through([
                new FilterCategoryItem($this->filters),
            ])
            ->then(
                fn (Builder $builder) => $builder->search($this->search, 'name', 'description', 'reference') // @phpstan-ignore-line
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->quantity)
            );
    }

    public function update(Item $item): void
    {
        $this->emitTo(Update::class, 'item::update::load', $item);
    }

    public function delete(Item $item): void
    {
        $this->emitTo(Delete::class, 'item::delete::load', $item);
    }
}
