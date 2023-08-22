<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class SettingsController extends Controller
{
    public function __invoke(): View
    {
        return view('settings');
    }
}
