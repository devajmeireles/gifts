<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Signature;
use Carbon\{CarbonInterval, CarbonPeriod};
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
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
        sleep(1);
    }

    public function getChartProperty(): array
    {
        return collect($this->dates())
            ->merge($this->count())
            ->mapWithKeys(function (int $value, string $date) {
                return [
                    Carbon::parse($date)->format('d/m') => $value,
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

        return collect($period->toArray())
            ->mapWithKeys(fn ($date) => [$date->format('Y-m-d') => 0])
            ->toArray();
    }

    private function count(): array
    {
        return Signature::query()
            ->countGroupByInRange(now()->subMonthNoOverflow()->format('Y-m-d'), now()->format('Y-m-d'))
            ->pluck('total', 'date')
            ->toArray();
    }
}
