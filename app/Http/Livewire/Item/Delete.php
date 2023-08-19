<?php

namespace App\Http\Livewire\Item;

use App\Models\Item;
use Exception;
use Livewire\Component;
use WireUi\Traits\Actions;

class Delete extends Component
{
    use Actions;

    public ?Item $item = null;

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
        $this->notification()->confirm([
            'title'       => 'Confirmação!',
            'description' => 'Deseja realmente deletar este item?',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Sim!',
                'method' => 'delete',
            ],
        ]);
    }

    public function delete(): void
    {
        try {
            $this->item->delete();

            $this->emitUp('item::index::refresh');
            $this->notification()->success('Item deletado com sucesso!');

            return;
        } catch (Exception $e) {
            report($e);
        }

        $this->notification()->error('Erro ao deletar item!');
    }
}
