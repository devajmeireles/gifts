<?php

namespace App\Http\Controllers;

use App\Exports\Item\ItemExport;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ItemController extends Controller
{
    public function index(): View
    {
        return view('items');
    }

    public function export(?Category $category): BinaryFileResponse
    {
        $file = sprintf('itens-%s.xlsx', now()->format('Y-m-d_H:i:s'));

        return Excel::download(new ItemExport($category), $file);
    }
}
