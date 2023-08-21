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
        'frontend::reset' => 'category',
    ];

    public function render(): View
    {
        return view('livewire.frontend.index');
    }

    public function category(): void
    {
        $this->filtered = false;

        $this->data = Category::with('items')
            ->withCount(['items' => fn (Builder $query) => $query->active()]) // @phpstan-ignore-line
            ->active()
            ->limit($this->limit)
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
            ->limit($this->limit)
            ->get();
    }
}
