<?php

namespace App\Http\Livewire\Contracts;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

interface ShouldExport
{
    public function exportable(): array;
}
