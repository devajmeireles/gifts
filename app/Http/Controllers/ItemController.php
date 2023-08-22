<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class ItemController extends Controller
{
    public function index(): View
    {
        return view('items');
    }
}
