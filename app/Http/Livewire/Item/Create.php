<?php

namespace App\Http\Livewire\Item;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.item.create');
    }

    public function create(): void
    {
        $this->modal = false;

        $this->notification()->success('Item criado com sucesso!');
    }
}
