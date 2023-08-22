<?php

namespace App\Http\Livewire\Contracts;

use App\Exports\Signature\SignatureExport;

interface MustExportSignature
{
    public function exportable(): SignatureExport;
}
