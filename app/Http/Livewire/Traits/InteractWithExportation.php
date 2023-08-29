<?php

namespace App\Http\Livewire\Traits;

use App\Http\Livewire\{Item, Presence, Signature};
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

trait InteractWithExportation
{
    abstract public function clear(): void;

    public function export(): Redirector|RedirectResponse
    {
        $exportable = $this->exportable();

        $this->clear();

        return redirect($this->route(), [...$exportable]);
    }

    private function route(): string
    {
        return match (static::class) {
            Item\Filter::class      => route('admin.items.export'),
            Presence\Filter::class  => route('admin.presences.export'),
            Signature\Filter::class => route('admin.signatures.export'),
        };
    }
}
