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
        $signatures = $item->signatures->count();

        $message = $signatures > 0
            ? __('app.item.delete.signature_exists', ['count' => $signatures])
            : 'Deseja realmente deletar este item?';

        $this->dialog()->confirm([
            'title'       => 'Confirmação!',
            'description' => $message,
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
