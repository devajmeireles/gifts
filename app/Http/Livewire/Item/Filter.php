<?php

namespace App\Http\Livewire\Item;

use App\Exports\Contracts\ShouldExport;
use App\Http\Livewire\Traits\InteractWithExportation;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use WireUi\Traits\Actions;

class Filter extends Component implements ShouldExport
{
    use Actions;
    use InteractWithExportation;

    public bool $modal = false;

    public bool $filtered = false;

    public ?int $category = null;

    public int $count = 1;

    public function mount(): void
    {
        $this->filtered = Cache::has('item::index::filter');
    }

    public function render(): View
    {
        return view('livewire.item.filter');
    }

    public function updatedModal(): void
    {
        if (!$this->modal) {
            $this->resetExcept('modal');
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

        Cache::put('item::index::filter', $this->category);

        $this->filtered = true;
    }

    public function clear(): void
    {
        $this->reset();

        $this->emitUp('item::index::refresh');

        Cache::forget('item::index::filter');
    }

    public function exportable(): array
    {
        return [
            'category' => $this->category,
        ];
    }
}
