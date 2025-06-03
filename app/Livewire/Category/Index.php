<?php

namespace App\Livewire\Category;

use App\Livewire\Traits\Pagination;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Index extends Component
{
    use Pagination;

    public function render(): View
    {
        return view('livewire.category.index');
    }

    #[Computed]
    public function headers(): array
    {
        return [
            ['index' => 'id', 'label' => '#'],
            ['index' => 'name', 'label' => 'Nome'],
            ['index' => 'items_count', 'label' => 'Qnt. de Itens'],
            ['index' => 'status', 'label' => 'Status'],
            ['index' => 'action'],
        ];
    }

    #[Computed]
    private function rows(): LengthAwarePaginator
    {
        return Category::withCount('items')
            ->search($this->search, 'name', 'description')
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity);
    }
}
