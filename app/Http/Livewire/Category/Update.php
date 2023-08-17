<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use WireUi\Traits\Actions;

class Update extends Component
{
    use Actions;

    public Category $category;

    public bool $modal = false;

    protected $listeners = [
        'category::update::load' => 'load',
    ];

    public function render(): View
    {
        return view('livewire.category.update');
    }

    public function load(Category $category): void
    {
        $this->category = $category;
        $this->modal    = true;
    }

    public function rules(): array
    {
        return [
            'category.name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('items', 'name')
                    ->ignore($this->category->id),
            ],
            'category.description' => [
                'nullable',
                'max:255',
            ],
            'category.is_active' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function update(): void
    {
        $this->validate();

        $this->modal = false;

        try {
            $this->category->save();

            $this->emitUp('category::index::refresh');
            $this->notification()->success('Categoria atualizada com sucesso!');

            return;
        } catch (Exception $e) {
            report($e);
        }

        $this->notification()->error('Erro ao atualizar categoria!');
    }
}
