<?php

namespace App\Http\Controllers;

use App\Models\{Category, Item};
use Illuminate\Contracts\View\View;

class SignatureController extends Controller
{
    public function index(): View
    {
        return view('signatures');
    }
}
