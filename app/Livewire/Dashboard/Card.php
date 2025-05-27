<?php

namespace App\Livewire\Dashboard;

use App\Enums\Dashboard\CardType;
use App\Models\Item;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Card extends Component
{
    public CardType $type;

    public int $quantity = 0;

    public function render(): View
    {
        return view('livewire.dashboard.card');
    }

    public function placeholder(): string
    {
        return <<<'HTML'
        <x-card>
            <div class="flex animate-pulse space-x-4">
                <div class="flex-1 py-1 space-y-6">
                    <div class="space-y-3">
                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-1 h-2 rounded bg-primary-200"></div>
                            <div class="col-span-1 h-2 rounded bg-primary-200"></div>
                            <div class="col-span-1 h-2 rounded bg-primary-200"></div>
                        </div>
                        <div class="h-2 rounded bg-primary-200"></div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-1 h-2 rounded bg-primary-200"></div>
                            <div class="col-span-1 h-2 rounded bg-primary-200"></div>
                            <div class="col-span-1 h-2 rounded bg-primary-200"></div>
                        </div>
                    </div>
                </div>
            </div>
        </x-card>
        HTML;
    }

    #[Computed]
    public function load(): void
    {
        $this->quantity = (match ($this->type) {
            CardType::AllItems         => fn () => Item::count(),
            CardType::AllSignedItems   => fn () => Item::whereHas('signatures')->count(),
            CardType::AllUnsignedItems => fn () => Item::whereDoesntHave('signatures')->count(),
        })();
    }
}
