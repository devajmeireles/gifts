<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('items');
    }
}
