<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\{Builder, Collection};
use Livewire\Component;

class Index extends Component
{
    public ?Category $category;

    public ?Collection $data = null;

    public bool $filtered = false;

    public int $limit = 9;

    public ?string $search = null;

    protected $listeners = [
        'frontend::reset'      => 'category',
        'frontend::load::more' => 'item',
    ];

    public function render(): View
    {
        return view('livewire.frontend.index');
    }

    public function more(): void
    {
        $this->limit += 9;

        $this->emitSelf('frontend::load::more', [
            'category' => $this->category,
        ]);
    }

    public function category(): void
    {
        $this->reset('filtered', 'limit', 'search');

        $this->data = Category::with('items')
            ->withCount(['items' => fn (Builder $query) => $query->active()]) // @phpstan-ignore-line
            ->active()
            ->oldest('name')
            ->get();
    }

    public function updatedSearch(): void
    {
        $this->item($this->category);
    }

    public function item(Category $category): void
    {
        $this->filtered = true;
        $this->category = $category;

        $this->data = $category->items()
            ->search($this->search, 'name')
            ->with('signatures')
            ->active()
            ->take($this->limit)
            ->oldest('name')
            ->get();
    }
}
