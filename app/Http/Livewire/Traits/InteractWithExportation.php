<?php

namespace App\Http\Livewire\Traits;

use Illuminate\Routing\Redirector;

trait InteractWithExportation
{
    abstract public function clear(): void;

    public function export(): Redirector
    {
        $exportable = $this->exportable();

        $this->clear();

        $this->modal = false;

        return redirect(route('admin.items.export', [...$exportable]));
    }
}
