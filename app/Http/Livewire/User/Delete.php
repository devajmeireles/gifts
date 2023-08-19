<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Exception;
use Livewire\Component;
use WireUi\Traits\Actions;

class Delete extends Component
{
    use Actions;

    public ?User $user = null;

    public function render(): string
    {
        return <<<'blade'
            <div>
                <x-button.circle negative
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
            'description' => 'Deseja realmente deletar este usuário?',
            'icon'        => 'question',
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
        if (user()->is($this->user)) {
            $this->notification()->error('Você não pode deletar a si mesmo!');

            return;
        }

        try {
            $this->user->delete();

            $this->emitUp('user::index::refresh');
            $this->notification()->success('Usuário deletado com sucesso!');

            return;
        } catch (Exception $e) {
            report($e);
        }

        $this->notification()->error('Erro ao deletar usuário!');
    }
}
