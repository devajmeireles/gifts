<?php

namespace App\Http\Livewire\Item;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class Filter extends Component
{
    use Actions;

    public bool $modal = false;

    public bool $filtered = false;

    public ?int $category = null;

    public int $count = 1;

    public function render(): View
    {
        return view('livewire.item.filter');
    }

    public function updatedModal(): void
    {
        if (!$this->modal) {
            $this->category = null;
        }
    }

    public function filter(): void
    {
        $this->modal = false;
        $this->count = 1;

        if (!$this->category) {
            $this->notification()->error('Ops!', 'Selecione ao menos uma categoria.');

            return;
        }

        $this->emitUp('item::index::filter', [
            'category' => $this->category,
        ]);

        $this->filtered = true;
    }

    public function clear(): void
    {
        $this->category = null;

        $this->filtered = false;
        $this->count    = 0;

        $this->emitUp('item::index::refresh');
    }
}
