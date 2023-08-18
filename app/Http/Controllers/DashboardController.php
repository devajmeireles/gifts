<?php

namespace App\Http\Controllers;

use Carbon\{CarbonInterval, CarbonPeriod};
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $period = new CarbonPeriod(
            now()->subMonthNoOverflow(),
            now(),
            CarbonInterval::days()
        );

        $dates = [];

        foreach ($period as $date) {
            $dates[] = $date->format('d/m/Y');
        }

        return view('dashboard', [
            'dates' => $dates,
        ]);
    }
}
