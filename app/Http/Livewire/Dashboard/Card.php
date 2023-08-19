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
        $this->quantity = match ($this->type) {
            CardType::AllItems         => $this->allItems(),
            CardType::AllSignedItems   => $this->allSignedItems(),
            CardType::AllUnsignedItems => $this->allUnsignedItems(),
        };
    }

    private function allItems(): int
    {
        return Item::count();
    }

    private function allSignedItems(): int
    {
        return Item::whereHas('signatures')->count();
    }

    private function allUnsignedItems(): int
    {
        return Item::whereDoesntHave('signatures')->count();
    }
}
