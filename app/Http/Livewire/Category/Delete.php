<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use Exception;
use Livewire\Component;
use WireUi\Traits\Actions;

class Delete extends Component
{
    use Actions;

    public Category $category;

    protected $listeners = [
        'category::delete::load' => 'load',
    ];

    public function render(): string
    {
        return <<<'blade'
            <div>
            </div>
        blade;
    }

    public function load(Category $category): void
    {
        $this->category = $category;

        $this->notification()->confirm([
            'title'       => 'Confirmação!',
            'description' => 'Deseja realmente deletar esta categoria?',
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
            $this->category->delete();

            $this->emitUp('category::index::refresh');
            $this->notification()->success('Categoria deletada com sucesso!');

            return;
        } catch (Exception $e) {
            report($e);
        }

        $this->notification()->error('Erro ao deletar categoria!');
    }

    public function cancel(): void
    {
        $this->notification()->info('Operação cancelada!');
    }
}
