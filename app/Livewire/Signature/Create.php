<?php

namespace App\Livewire\Signature;

use App\Livewire\Traits\InteractWithSignatureCreation;
use App\Models\Item;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    use InteractWithSignatureCreation {
        create as createSignature;
        rules as signatureRules;
    }

    public bool $modal = false;

    public int $quantity = 1;

    public ?int $selected = null;

    public int $delivery = 1;

    protected array $validationAttributes = [
        'selected' => 'item',
    ];

    public function render(): View
    {
        return view('livewire.signature.create');
    }

    public function updatedSelected(): void
    {
        if ($this->selected) {
            $this->item = Item::find($this->selected);
        }
    }

    public function create(): void
    {
        $this->createSignature();
    }
}
