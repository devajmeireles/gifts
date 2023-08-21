<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\{Builder, Collection};
use Livewire\Component;

class Index extends Component
{
    public bool $category = true;

    public bool $item = false;

    public int $limit = 9;

    public ?Collection $data = null;

    protected $listeners = [
        'frontend::reset' => 'category',
    ];

    public function render(): View
    {
        return view('livewire.frontend.index');
    }

    public function category(): void
    {
        $this->category = true;
        $this->item     = false;

        $this->data = Category::with('items')
            ->withCount(['items' => fn (Builder $query) => $query->active()])
            ->active()
            ->limit($this->limit)
            ->get();
    }

    public function item(Category $category): void
    {
        $this->category = false;
        $this->item     = true;

        $this->data = $category->items()
            ->with('signatures')
            ->active()
            ->limit($this->limit)
            ->get();
    }
}
