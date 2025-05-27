<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class UserController
{
    public function __invoke(): View
    {
        return view('users');
    }
}
