<?php

namespace App\Http\Livewire\Signature;

use App\Enums\DeliveryType;
use App\Models\{Item, Signature};
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions;

    public Signature $signature;

    public ?Item $item = null;

    public bool $modal = false;

    public int $quantity = 1;

    public ?int $selected = null;

    public int $delivery = 1;

    public function render(): View
    {
        return view('livewire.signature.create');
    }

    public function updatedModal(): void
    {
        $this->signature        = new Signature();
        $this->signature->phone = '';
    }

    public function updatedSelected(): void
    {
        if ($this->selected) {
            $this->item = Item::find($this->selected);
        }
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

    public function create(): void
    {
        $this->validate();

        $this->signature->delivery = DeliveryType::from($this->delivery);

        if (!$this->item->available()) {
            $this->resetExcept('item', 'signature');
            $this->notification()->error('Item indisponível para assinatura!');

            return;
        }

        try {
            $this->item->signatures()
                ->createMany(
                    Collection::times($this->quantity, fn () => $this->signature->toArray())
                        ->toArray()
                );

            $this->resetExcept('item', 'signature');

            $this->item->update(['last_signed_at' => now()]);

            $this->signature = new Signature();
            $this->item      = new Item();

            $this->emitUp('signature::index::refresh');
            $this->notification()->success('Assinatura criada com sucesso!');

            return;
        } catch (Exception $e) {
            report($e);
        }

        $this->notification()->error('Erro ao criar assinatura!');
    }
}
