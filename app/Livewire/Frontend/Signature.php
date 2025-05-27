<?php

namespace App\Livewire\Frontend;

use App\Livewire\Traits\InteractWithSignatureCreation;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Signature extends Component
{
    use InteractWithSignatureCreation {
        create as createSignature;
        rules as signatureRules;
    }

    public bool $modal = false;

    public int $delivery = 1;

    public int $quantity = 1;

    public int $quota = 1;

    public function render(): View
    {
        return view('livewire.frontend.signature');
    }

    public function create(): void
    {
        if ($this->item->availableQuantity() === 0) {
            $this->dialog()->error('Ops!', 'Não há mais itens disponíveis para assinatura.');

            return;
        }

        $this->createSignature();
    }
}
