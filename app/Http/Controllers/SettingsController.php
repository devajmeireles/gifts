<?php

namespace App\Http\Controllers;

class SettingsController extends Controller
{
    public function __invoke()
    {
        return view('settings');
    }
}
