<?php

namespace App\Http\Livewire\Signature;

use App\Enums\DeliveryType;
use App\Models\Item;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions;

    public ?Item $item = null;

    public bool $modal = false;

    public int $quantity = 1;

    public string $name = '';

    public string $phone = '';

    public ?int $selected = null;

    public int $delivery = 1;

    public string $observation = '';

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

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'min:3', 'max:255'],
            'phone'       => ['required', 'string', 'min:3', 'max:255'],
            'delivery'    => ['required', Rule::enum(DeliveryType::class)],
            'quantity'    => ['required', 'numeric', 'min:1'],
            'observation' => ['nullable', 'string', 'min:3', 'max:255'],
        ];
    }

    public function create(): void
    {
        $this->validate();

        try {
            $this->item->signatures()->createMany(Collection::times($this->quantity, fn () => [
                'name'        => $this->name,
                'phone'       => $this->phone,
                'delivery'    => $this->delivery,
                'observation' => $this->observation,
            ])->toArray());

            $this->resetExcept('item');
            $this->item = new Item();

            //TODO: talvez seja melhor usar last_signed_at
            $this->item->update(['signed_at' => now()]);

            $this->emitUp('signature::index::refresh');
            $this->notification()->success('Assinatura criada com sucesso!');

            return;
        } catch (Exception $e) {
            report($e);
        }

        $this->notification()->error('Erro ao criar assinatura!');
    }
}
