<?php

namespace App\Http\Controllers;

use App\Exports\Presence\PresenceExport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PresenceController
{
    public function index(): View
    {
        return view('presences');
    }

    public function export(): BinaryFileResponse
    {
        $file = sprintf('presenças-%s.xlsx', now()->format('Y-m-d_H:i'));

        return Excel::download(new PresenceExport(), $file);
    }
}
