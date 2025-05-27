<?php

namespace App\Livewire\Item;

use App\Filters\Item\FilterCategoryItem;
use App\Livewire\Traits\Pagination;
use App\Models\Item;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Pipeline;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Index extends Component
{
    use Pagination;

    protected $listeners = [
        'item::index::refresh' => '$refresh',
        'item::index::filter'  => 'filter',
    ];

    private array $filters = [];

    #[Computed]
    public function headers(): array
    {
        return [
            ['column' => 'id', 'label' => '#'],
            ['column' => 'name', 'label' => 'Nome'],
            ['column' => 'category', 'label' => 'Categoria'],
            ['column' => 'quantity', 'label' => 'Quantidade'],
            ['column' => 'signed', 'label' => 'Qnt. Assinado'],
            ['column' => 'status', 'label' => 'Status'],
            ['column' => 'action'],
        ];
    }

    public function render(): View
    {
        return view('livewire.item.index');
    }

    #[Computed]
    public function rows(): LengthAwarePaginator
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

    public function filter(array $filters): void
    {
        $this->filters = [...$filters];
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
