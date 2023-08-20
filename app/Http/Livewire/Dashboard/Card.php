<?php

namespace App\Http\Livewire\Dashboard;

use App\Enums\Dashboard\CardType;
use App\Models\Item;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Card extends Component
{
    public CardType $type;

    public int $quantity = 0;

    public function render(): View
    {
        return view('livewire.dashboard.card');
    }

    public function load(): void
    {
        sleep(1);

        $this->quantity = (match ($this->type) {
            CardType::AllItems         => fn () => Item::count(),
            CardType::AllSignedItems   => fn () => Item::whereHas('signatures')->count(),
            CardType::AllUnsignedItems => fn () => Item::whereDoesntHave('signatures')->count(),
        })();
    }
}
