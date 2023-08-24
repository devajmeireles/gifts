<?php

namespace App\Http\Livewire\Presence;

use App\Models\Presence;
use Exception;
use Livewire\Component;
use WireUi\Traits\Actions;

class Delete extends Component
{
    use Actions;

    public Presence $presence;

    public function render(): string
    {
        return <<<'blade'
            <x-button.circle primary
                             icon="trash"
                             wire:click="confirmation"
            />
        blade;
    }

    public function confirmation(): void
    {
        //TODO: por uma mensagem diferente se tiver assinaturas

        $this->dialog()->confirm([
            'title'       => 'Confirmação!',
            'description' => 'Deseja realmente deletar esta assinatura?',
            'icon'        => 'error',
            'accept'      => [
                'label'  => 'Sim!',
                'method' => 'delete',
            ],
        ]);
    }

    public function delete(): void
    {
        try {
            $this->presence->delete();

            $this->emitUp('presence::index::refresh');
            $this->notification()->success('Presença deletada com sucesso!');

            return;
        } catch (Exception $e) {
            report($e);
        }

        $this->notification()->error('Erro ao deletar presença!');
    }
}
