<?php

namespace App\Http\Livewire\Signature;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Filter extends Component
{
    public bool $modal = false;

    public bool $filtered = false;

    public int $count = 0;

    public ?int $category = null;

    public ?int $item = null;

    public ?string $start = null;

    public ?string $end = null;

    public function render(): View
    {
        return view('livewire.signature.filter');
    }

    public function updatedModal(): void
    {
        if (!$this->modal) {
            $this->category = null;
        }
    }

    public function filter(): void
    {
        $this->emitUp('signature::index::filter', [
            'category' => $this->category,
            'item'     => $this->item,
            'start'    => $this->start,
            'end'      => $this->end,
        ]);

        $this->filtered = true;

        $this->count = collect([
            $this->category,
            $this->item,
            $this->start,
            $this->end,
        ])->filter()->count();

        $this->modal = false;
    }

    public function clear(): void
    {
        $this->category = null;
        $this->item     = null;
        $this->start    = null;
        $this->end      = null;

        $this->filtered = false;
        $this->count    = 0;

        $this->emitUp('signature::index::refresh');
    }
}
