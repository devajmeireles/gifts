<?php

namespace App\Http\Livewire\Contracts;

use App\Exports\Item\ItemExport;

interface MustExportItem
{
    public function exportable(): ItemExport;
}
