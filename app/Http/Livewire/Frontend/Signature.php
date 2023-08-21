<?php

namespace App\Http\Livewire\Frontend;

use App\Models\{Item, Signature as Model};
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Signature extends Component
{
    public Model|null $signature = null;

    public ?Item $item = null;

    public bool $modal = false;

    public int $quantity = 1;

    public int $quota = 1;

    public function mount(): void
    {
        $this->signature = new Model(['phone' => '']);
    }

    public function render(): View
    {
        return view('livewire.frontend.signature');
    }
}
