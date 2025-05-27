<?php

namespace App\Livewire\Traits;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

trait Pagination
{
    use WithPagination;

    public int $quantity = 10;

    public string $search = '';

    public array $sort = [
        'column'    => 'created_at',
        'direction' => 'desc',
    ];

    #[Computed]
    abstract public function headers(): array;

    #[Computed]
    abstract public function rows(): LengthAwarePaginator;

    public function mountPagination(Request $request): void
    {
        $this->setPage($request->get('page', 1));

        $this->search   = $request->get('search', '');
        $this->quantity = $request->get('quantity', $this->quantity);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->search = trim($this->search);
    }

    public function updatingQuantity(): void
    {
        $this->resetPage();
    }
}
