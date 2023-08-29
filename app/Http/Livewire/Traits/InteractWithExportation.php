<?php

namespace App\Http\Livewire\Traits;

use App\Http\Livewire\{Item, Presence, Signature};
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

trait InteractWithExportation
{
    abstract public function clear(): void;

    /** @throws Exception */
    public function export(): Redirector|RedirectResponse
    {
        $exportable = $this->exportable();

        $this->clear();

        return redirect($this->route($exportable));
    }

    /** @throws Exception */
    private function route(array $exportable): string
    {
        return match (static::class) {
            Item\Filter::class      => route('admin.items.export', [...$exportable]),
            Presence\Filter::class  => route('admin.presences.export', [...$exportable]),  // @phpstan-ignore-line
            Signature\Filter::class => route('admin.signatures.export', [...$exportable]), // @phpstan-ignore-line
            default                 => throw new Exception('Route not found', [...$exportable]), // @phpstan-ignore-line
        };
    }
}
