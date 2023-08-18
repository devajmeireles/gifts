<?php

namespace App\Http\Livewire\Dashboard;

use App\Enums\Dashboard\CardType;
use Illuminate\Contracts\View\View;
use Livewire\Component;

/**
 * @property-read int $quantity
 */
class Card extends Component
{
    public CardType $type;

    public function render(): View
    {
        return view('livewire.dashboard.card');
    }

    public function load()
    {
        sleep(2);
    }

    public function getQuantityProperty(): int
    {
        //TODO: tratar isso
        return rand(1, 100);
    }
}
