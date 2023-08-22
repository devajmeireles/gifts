<?php

namespace App\Http\Controllers;

use App\Exports\Signature\SignatureExport;
use App\Models\{Category, Item};
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SignatureController extends Controller
{
    public function index(): View
    {
        return view('signatures');
    }

    public function export(Request $request)
    {
        $file = sprintf('assinaturas-%s.xlsx', now()->format('Y-m-d_H:i:s'));

        return Excel::download(new SignatureExport(...$request->query()), $file);
    }
}
