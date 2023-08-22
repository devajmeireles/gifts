<?php

namespace App\Http\Controllers;

use App\Exports\Item\ItemExport;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ItemController extends Controller
{
    public function index(): View
    {
        return view('items');
    }

    public function export(Request $request): BinaryFileResponse
    {
        $file = sprintf('itens-%s.xlsx', now()->format('Y-m-d_H:i'));

        return Excel::download(new ItemExport(...$request->query()), $file);
    }
}
