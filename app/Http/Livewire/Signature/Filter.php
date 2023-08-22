<?php

namespace App\Http\Livewire\Signature;

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

    public int $count = 0;

    public ?int $category = null;

    public ?int $item = null;

    public ?string $start = null;

    public ?string $end = null;

    public function mount(): void
    {
        $cache = Cache::get('signature::index::filter');

        $this->filtered = ($count = collect($cache)->count()) > 0;
        $this->count    = $count;
    }

    public function render(): View
    {
        return view('livewire.signature.filter');
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

        $collect = collect([
            'category' => $this->category,
            'item'     => $this->item,
            'start'    => $this->start,
            'end'      => $this->end,
        ])->filter();

        if ($collect->isEmpty()) {
            $this->notification()->error('Ops!', 'Selecione ao menos um filtro.');

            return;
        }

        $this->filtered = true;
        $this->count    = $collect->count();

        $filters = [...$collect->toArray()];

        $this->emitUp('signature::index::filter', $filters);

        Cache::put('signature::index::filter', $filters);
    }

    public function clear(): void
    {
        $this->reset();

        $this->emitUp('signature::index::refresh');

        Cache::forget('signature::index::filter');
    }

    public function exportable(): array
    {
        return [
            'category' => $this->category,
            'item'     => $this->item,
            'start'    => $this->start,
            'end'      => $this->end,
        ];
    }
}
