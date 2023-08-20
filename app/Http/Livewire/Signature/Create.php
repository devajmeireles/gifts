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

    protected array $validationAttributes = [
        'selected' => 'item',
    ];

    public function mount(): void
    {
        $this->signature = new Signature(['phone' => '']);
    }

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
            'signature.name'        => ['required', 'string', 'min:3', 'max:255'],
            'signature.phone'       => ['nullable', 'string', 'min:3', 'max:255'],
            'delivery'              => ['required', Rule::enum(DeliveryType::class)],
            'quantity'              => ['required', 'numeric', 'min:1'],
            'signature.observation' => ['nullable', 'string', 'min:3', 'max:255'],
            'selected'              => ['required'],
        ];
    }

    public function create(): void
    {
        $this->validate();

        $this->signature->delivery = DeliveryType::from($this->delivery);

        if ($this->quantity > $this->item->quantity) {
            $this->resetExcept('item', 'signature');
            $this->notification()->error('Erro de Quantidade', 'Quantidade selecionada é superior a quantidade de itens');

            return;
        }

        try {
            $this->item->signatures()
                ->createMany(
                    Collection::times($this->quantity, fn () => $this->signature->toArray())
                        ->toArray()
                );

            $this->resetExcept('item', 'signature');

            if ($this->item->signatures()->count() === $this->item->quantity) {
                $this->item->is_active = false;
            }

            $this->item->last_signed_at = now();
            $this->item->save();

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
