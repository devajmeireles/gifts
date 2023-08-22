<?php

namespace App\Http\Livewire\Traits;

use App\Http\Livewire\{Item, Signature};
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

trait InteractWithExportation
{
    abstract public function clear(): void;

    public function export(): BinaryFileResponse
    {
        $exportable = $this->exportable();

        $this->clear();

        $this->modal = false;

        return Excel::download(
            $exportable,
            sprintf('%s-%s.xlsx', $this->name(), now()->format('Y-m-d_H:i:s'))
        );
    }

    private function name(): string
    {
        return match (self::class) {
            Signature\Filter::class => 'assinaturas',
            Item\Filter::class      => 'itens',
        };
    }
}
