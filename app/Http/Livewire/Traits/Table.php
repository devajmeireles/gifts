<?php

namespace App\Http\Livewire\Traits;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Livewire\WithPagination;

trait Table
{
    use WithPagination;

    public int $quantity = 10;

    public string $search = '';

    public string $sort = 'created_at';

    public string $direction = 'desc';

    public function mount(Request $request): void
    {
        $this->setupPagination($request);
    }

    public function setupPagination(Request $request): void
    {
        $this->page      = $request->get('page', $this->page);
        $this->search    = $request->get('search', '');
        $this->sort      = $request->get('sort', $this->sort);
        $this->direction = $request->get('direction', $this->direction);
        $this->quantity  = $request->get('quantity', $this->quantity);
    }

    public function sort($by, $direction): void
    {
        $this->sort      = $by;
        $this->direction = $direction;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingQuantity(): void
    {
        $this->resetPage();
    }

    public function nextPage($pageName = 'page'): void
    {
        $this->setPage(isset($this->paginators[$pageName]) ? $this->paginators[$pageName] + 1 : 2, $pageName);
    }

    public function previousPage($pageName = 'page'): void
    {
        $this->setPage(isset($this->paginators[$pageName]) ? max($this->paginators[$pageName] - 1, 1) : 1, $pageName);
    }

    public function initializeWithPagination(): void
    {
        Paginator::currentPageResolver(function (): int {
            return $this->page;
        });

        Paginator::defaultView($this->paginationView());
    }

    public function paginationView(): string
    {
        return 'vendor.livewire.simple-tailwind';
    }
}
