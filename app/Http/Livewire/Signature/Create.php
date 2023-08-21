<?php

namespace App\Http\Livewire\Signature;

use App\Actions\Signature\CreateSignature;
use App\Enums\DeliveryType;
use App\Models\{Item, Signature, Signature as Model};
use Exception;
use Illuminate\Contracts\View\View;
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

        try {
            app(CreateSignature::class)->execute($this->item, $this->signature, $this->quantity);

            $this->emitUp('signature::index::refresh');
            $this->notification()->success('Assinatura criada com sucesso!');

            return;
        } catch (Exception $e) {
            report($e);
        } finally {
            $this->signature();
        }

        $this->notification()->error('Erro ao criar assinatura!');
    }

    private function signature(): void
    {
        $this->resetExcept('item', 'signature');

        $this->signature = new Model();
        $this->item      = new Item();
    }
}
