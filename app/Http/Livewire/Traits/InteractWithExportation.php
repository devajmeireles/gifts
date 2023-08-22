<?php

namespace App\Http\Livewire\Traits;

use App\Http\Livewire\Item\Filter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

trait InteractWithExportation
{
    abstract public function clear(): void;

    public function export(): Redirector|RedirectResponse
    {
        $exportable = $this->exportable();

        $this->clear();

        $route = $this instanceof Filter
            ? 'admin.items.export'
            : 'admin.signatures.export';

        return redirect(route($route, [...$exportable]));
    }
}
