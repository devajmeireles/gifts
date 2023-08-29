<?php

namespace App\Http\Livewire\Signature;

use App\Models\Signature;
use App\Services\Settings\Facades\Settings;
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
                                 primary
                                 icon="trash"
                                 wire:click="confirmation"
                />
            </div>
        blade;
    }

    public function confirmation(): void
    {
        $message = "Deseja realmente deletar esta assinatura?";

        if (
            Settings::get('converter_assinaturas_em_presenca') &&
            $this->signature->presence_id !== null // @phpstan-ignore-line
        ) {
            $message .= " A presença registrada também será deletada.";
        }

        $this->dialog()->confirm([
            'title'       => 'Confirmação',
            'description' => $message,
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
            if (Settings::get('converter_assinaturas_em_presenca')) {
                $this->signature->presence()->delete();
            }

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
