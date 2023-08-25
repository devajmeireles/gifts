<?php

namespace App\Http\Livewire\Traits;

use App\Actions\Signature\CreateSignature;
use App\Enums\DeliveryType;
use App\Http\Livewire\Frontend\Signature;
use App\Http\Livewire\Signature\Create;
use App\Models\{Item, Signature as Model};
use App\Notifications\SignatureCreated;
use Exception;
use Illuminate\Validation\Rule;
use WireUi\Actions\{Dialog, Notification};

trait InteractWithSignatureCreation
{
    public Model|null $signature = null;

    public ?Item $item = null;

    public function mount(): void
    {
        $this->signature = new Model(['phone' => '']);
    }

    public function rules(): array
    {
        $rules = [
            'signature.name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],
            'signature.phone' => [
                'string',
                'min:7',
                'max:255',
                Rule::when($this instanceof Signature, ['required'], ['nullable']),
            ],
            'delivery' => [
                'required',
                Rule::enum(DeliveryType::class),
            ],
            'quantity' => [
                'required',
                'numeric',
                'min:1',
            ],
            'signature.observation' => [
                'nullable',
                'string',
                'min:3',
                'max:255',
            ],
        ];

        return array_merge($rules, $this instanceof Create ? ['selected' => ['required']] : []);
    }

    public function create(): void
    {
        $this->validate();

        $this->signature->delivery = DeliveryType::from($this->delivery);

        if (!$this->item->is_active) {
            $this->type()->error('Ops!', 'O item selecionado não está mais disponível.');

            return;
        }

        if ($this->quantity > ($available = $this->item->availableQuantity())) {
            $this->type()->error('Ops!', "Este item possui apenas $available unidade(s) disponívei(s).");

            return;
        }

        try {
            app(CreateSignature::class)->execute($this->item, $this->signature, $this->quantity);

            $this->item->notify(new SignatureCreated($this->signature, $this->quantity));

            $this->emitUp('signature::index::refresh');
            $this->emitUp('frontend::reset');
            $this->success();

            return;
        } catch (Exception $e) {
            report($e);
        } finally {
            $this->signature();
        }

        $this->error();
    }

    private function success(): void
    {
        (match (static::class) { // @phpstan-ignore-line
            Create::class    => fn () => $this->notification()->success('Assinatura criada com sucesso!'), // @phpstan-ignore-line
            Signature::class => fn () => $this->dialog()->success('Assinado!', $this->signature->delivery->thankYou()),
        })();
    }

    private function error(): void
    {
        (match (static::class) { // @phpstan-ignore-line
            Create::class    => fn () => $this->notification()->error('Erro ao criar assinatura!'), // @phpstan-ignore-line
            Signature::class => fn () => $this->dialog()->error('Ops!', 'Algo deu errado. Tente novamente, por gentileza.'),
        })();
    }

    private function type(): Notification|Dialog // @phpstan-ignore-line
    {
        return (match (static::class) { // @phpstan-ignore-line
            Create::class    => fn () => $this->notification(), // @phpstan-ignore-line
            Signature::class => fn () => $this->dialog()
        })();
    }

    private function signature(): void
    {
        $this->resetExcept('item', 'signature');

        $this->signature = new Model();
        $this->item      = new Item();
    }
}
