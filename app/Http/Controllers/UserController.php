<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    public function __invoke(): View
    {
        return view('users');
    }
}
