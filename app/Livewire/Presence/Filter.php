<?php

namespace App\Livewire\Presence;

use App\Exports\Contracts\ShouldExport;
use App\Livewire\Traits\InteractWithExportation;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Filter extends Component implements ShouldExport
{
    use InteractWithExportation;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.presence.filter');
    }

    public function clear(): void
    {
        //
    }

    public function exportable(): array
    {
        return [];
    }
}
