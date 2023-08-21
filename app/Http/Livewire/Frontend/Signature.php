<?php

namespace App\Http\Livewire\Frontend;

use App\Actions\Signature\CreateSignature;
use App\Enums\DeliveryType;
use App\Models\{Item, Signature as Model};
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use WireUi\Traits\Actions;

class Signature extends Component
{
    use Actions;

    public Model|null $signature = null;

    public ?Item $item = null;

    public bool $modal = false;

    public int $delivery = 1;

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

        if ($this->item->availableQuantity() === 0) {
            $this->dialog()->error('Ops!', 'Não há mais itens disponíveis para assinatura.');

            return;
        }

        $this->signature->delivery = DeliveryType::from($this->delivery);

        try {
            app(CreateSignature::class)->execute($this->item, $this->signature, $this->quantity);

            $this->emitUp('signature::index::refresh');
            $this->emitUp('frontend::reset');
            $this->dialog()->success('Assinado!', $this->signature->delivery->thankYou());

            return;
        } catch (Exception $e) {
            report($e);
        } finally {
            $this->signature();
        }

        $this->dialog()->error('Ops!', 'Algo deu errado. Tente novamente, por gentileza.');
    }

    private function signature(): void
    {
        $this->resetExcept('item', 'signature');

        $this->signature = new Model();
        $this->item      = new Item();
    }
}
