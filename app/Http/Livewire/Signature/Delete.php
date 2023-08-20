<?php

namespace App\Http\Livewire\Signature;

use App\Models\Signature;
use Exception;
use Livewire\Component;
use WireUi\Traits\Actions;

class Delete extends Component
{
    use Actions;

    public ?Signature $signature = null;

    public function render(): string
    {
        return <<<'blade'
            <div>
                <x-button.circle xs
                                 red
                                 icon="trash"
                                 wire:click="confirmation"
                />
            </div>
        blade;
    }

    public function confirmation(): void
    {
        $this->dialog()->confirm([
            'title'       => 'Confirmação',
            'description' => 'Deseja realmente deletar esta assinatura?',
            'icon'        => 'error',
            'accept'      => [
                'label'  => 'Sim!',
                'method' => 'delete',
            ],
            'reject' => [
                'label' => 'Não',
            ],
        ]);
    }

    public function delete(): void
    {
        try {
            $this->signature->item->is_active = true;

            if ($this->signature->item->quantity === 1) {
                $this->signature->item
                    ->update([
                        'last_signed_at' => null,
                    ]);
            }

            $this->signature->item->save();
            $this->signature->delete();

            $this->signature = new Signature();

            $this->emitUp('signature::index::refresh');
            $this->notification()->success('Assinatura deletada com sucesso!');

            return;
        } catch (Exception $e) {
            report($e);
        }

        $this->notification()->error('Erro ao deletar assinatura!');
    }
}
