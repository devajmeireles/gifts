<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = [
        'category::index::refresh' => '$refresh',
    ];

    public function render(): View
    {
        return view('livewire.category.index', [
            'categories' => $this->data(),
        ]);
    }

    private function data(): LengthAwarePaginator
    {
        return Category::withCount('items')
            ->search($this->search, 'name', 'description')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->quantity);
    }

    public function update(Category $category): void
    {
        $this->emitTo(Update::class, 'category::update::load', $category);
    }

    public function delete(Category $category): void
    {
        $this->emitTo(Delete::class, 'category::delete::load', $category);
    }
}
