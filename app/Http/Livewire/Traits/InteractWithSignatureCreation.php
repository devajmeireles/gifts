<?php

namespace App\Http\Livewire\Traits;

use App\Actions\Signature\CreateSignature;
use App\Enums\DeliveryType;
use App\Http\Livewire\Frontend\Signature;
use App\Http\Livewire\Signature\Create;
use App\Models\{Item, Signature as Model};
use Exception;
use Illuminate\Validation\Rule;

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
        $default = [
            'signature.name'        => ['required', 'string', 'min:3', 'max:255'],
            'signature.phone'       => ['nullable', 'string', 'min:3', 'max:255'],
            'delivery'              => ['required', Rule::enum(DeliveryType::class)],
            'quantity'              => ['required', 'numeric', 'min:1'],
            'signature.observation' => ['nullable', 'string', 'min:3', 'max:255'],
        ];

        if ($this instanceof Create) {
            $default = array_merge($default, ['selected' => ['required']]);
        }

        return $default;
    }

    public function create(): void
    {
        $this->validate();

        $this->signature->delivery = DeliveryType::from($this->delivery);

        try {
            app(CreateSignature::class)->execute($this->item, $this->signature, $this->quantity);

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
        (match (static::class) {
            Create::class    => fn () => $this->notification()->success('Assinatura criada com sucesso!'),
            Signature::class => fn () => $this->dialog()->success('Assinado!', $this->signature->delivery->thankYou()),
        })();
    }

    private function error(): void
    {
        (match (static::class) {
            Create::class    => fn () => $this->notification()->error('Erro ao criar assinatura!'),
            Signature::class => fn () => $this->dialog()->error('Ops!', 'Algo deu errado. Tente novamente, por gentileza.'),
        })();
    }

    private function signature(): void
    {
        $this->resetExcept('item', 'signature');

        $this->signature = new Model();
        $this->item      = new Item();
    }
}
