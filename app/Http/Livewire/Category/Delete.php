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

        $count = $category->items->count();
        $title = $count > 0
            ? "{$count} itens vinculados a esta categoria!"
            : "Confirmação";

        $this->notification()->confirm([
            'title'       => $title,
            'description' => "Deseja realmente deletar esta categoria?",
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
