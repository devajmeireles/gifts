<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Signature;
use Carbon\{CarbonInterval, CarbonPeriod};
use Illuminate\Contracts\View\View;
use Livewire\Component;

/**
 * @property-read array $chart
 */
class Chart extends Component
{
    public function render(): View
    {
        return view('livewire.dashboard.chart');
    }

    public function load(): void
    {
        sleep(2);
    }

    public function getChartProperty(): array
    {
        return collect($this->dates())
            ->mapWithKeys(function (string $date) {
                $index = explode('-', $date);
                $index = $index[2] . "/" . $index[1];

                return [
                    $index => $this->count($date),
                ];
            })->toArray();
    }

    private function dates(): array
    {
        $period = new CarbonPeriod(
            now()->subMonthNoOverflow(),
            now(),
            CarbonInterval::days()
        );

        $dates = [];

        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        return $dates;
    }

    private function count(string $date): int
    {
        return Signature::query()
            ->whereDate('created_at', $date)
            ->count();
    }
}
