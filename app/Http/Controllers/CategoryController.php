<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{
    public function __invoke(): View
    {
        return view('categories');
    }
}
