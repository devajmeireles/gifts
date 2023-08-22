<?php

namespace App\Exports\Contracts;

interface ShouldExport
{
    public function exportable(): array;
}
