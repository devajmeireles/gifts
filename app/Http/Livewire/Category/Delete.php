<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use Exception;
use Livewire\Component;
use WireUi\Traits\Actions;

class Delete extends Component
{
    use Actions;

    public ?Category $category = null;

    protected $listeners = [
        'category::delete::load' => 'load',
    ];

    public function render(): string
    {
        return <<<'blade'
            <div></div>
        blade;
    }

    public function load(Category $category): void
    {
        $this->category = $category;

        if ($category->items->count() > 0) {
            $this->dialog()->warning(
                __('Itens vinculados a categoria!'),
                'Remova os itens da categoria antes de poder deletá-la!'
            );

            return;
        }

        $this->dialog()->confirm([
            'title'       => 'Confirmação',
            'description' => "Deseja realmente deletar esta categoria?",
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
            $this->category->delete();

            $this->emitUp('category::index::refresh');
            $this->notification()->success('Categoria deletada com sucesso!');

            return;
        } catch (Exception $e) {
            report($e);
        }

        $this->notification()->error('Erro ao deletar categoria!');
    }
}
