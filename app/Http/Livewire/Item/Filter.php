<?php

namespace App\Http\Livewire\Item;

use App\Exports\Item\ItemExport;
use App\Http\Livewire\Contracts\{MustExportItem, ShouldExport};
use App\Http\Livewire\Traits\InteractWithExportation;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class Filter extends Component implements ShouldExport, MustExportItem
{
    use Actions;
    use InteractWithExportation;

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

    public function exportable(): ItemExport
    {
        return new ItemExport($this->category);
    }
}
