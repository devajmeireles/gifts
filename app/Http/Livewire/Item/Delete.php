<?php

namespace App\Http\Livewire\Item;

use App\Models\Item;
use Exception;
use Livewire\Component;
use WireUi\Traits\Actions;

class Delete extends Component
{
    use Actions;

    public Item $item;

    protected $listeners = [
        'item::delete::load' => 'load',
    ];

    public function render(): string
    {
        return <<<'blade'
            <div></div>
        blade;
    }

    public function load(Item $item): void
    {
        $this->item = $item;

        $this->notification()->confirm([
            'title'       => 'Confirmação!',
            'description' => 'Deseja realmente deletar este item?',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Sim!',
                'method' => 'delete',
            ],
            'reject' => [
                'label'  => 'Não, cancelar!',
                'method' => 'cancel',
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

    public function cancel(): void
    {
        $this->notification()->info('Operação cancelada!');
    }
}
