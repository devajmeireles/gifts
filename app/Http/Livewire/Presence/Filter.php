<?php

namespace App\Http\Livewire\Presence;

use App\Exports\Contracts\ShouldExport;
use App\Http\Livewire\Traits\InteractWithExportation;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class Filter extends Component implements ShouldExport
{
    use Actions;
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
