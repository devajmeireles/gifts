<?php

namespace App\Http\Livewire\Signature;

use App\Enums\DeliveryType;
use App\Models\{Item, Signature};
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use WireUi\Traits\Actions;

class Update extends Component
{
    use Actions;

    public ?Signature $signature;

    public ?Item $item = null;

    public bool $modal = false;

    public int $quantity = 1;

    public ?int $selected = null;

    public int $delivery = 1;

    public function mount(): void
    {
        $this->delivery = $this->signature->delivery->value;
        $this->selected = $this->signature->item_id;
        $this->item     = $this->signature->item;
    }

    public function rules(): array
    {
        return [
            'signature.name'        => ['required', 'string', 'min:3', 'max:255'],
            'signature.phone'       => ['required', 'string', 'min:3', 'max:255'],
            'delivery'              => ['required', Rule::enum(DeliveryType::class)],
            'quantity'              => ['required', 'numeric', 'min:1'],
            'signature.observation' => ['nullable', 'string', 'min:3', 'max:255'],
        ];
    }

    public function render(): View
    {
        return view('livewire.signature.update');
    }

    public function updatedSelected(): void
    {
        if ($this->selected) {
            $this->item = Item::find($this->selected);
        }
    }

    public function update(): void
    {
        $this->validate();

        $current     = $this->signature->item;
        $different   = $current->isNot($this->item);
        $this->modal = false;

        if ($different && !$this->item->available()) {
            $this->resetExcept('item', 'signature');
            $this->notification()->error('Item indisponível para assinatura!');

            return;
        }

        try {
            $this->signature->delivery = DeliveryType::from($this->delivery);
            $this->signature->item_id  = $this->selected;

            if ($different) {
                if ($this->item->signatures()->count() === $this->item->quantity) {
                    $this->item->is_active = false;
                }

                $this->item->last_signed_at = now();
                $this->item->save();

                $current->update(['last_signed_at' => null]);
            }

            $this->signature->save();

            $this->emitUp('signature::index::refresh');
            $this->notification()->success('Assinatura atualizada com sucesso!');

            return;
        } catch (Exception $e) {
            report($e);
        }

        $this->notification()->error('Erro ao atualizar a assinatura!');
    }
}
