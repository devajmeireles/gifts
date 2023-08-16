<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions;

    public Category $category;

    public bool $modal = false;

    public function mount(): void
    {
        $this->category = new Category(['is_active' => true]);
    }

    public function render(): View
    {
        return view('livewire.category.create');
    }

    public function rules(): array
    {
        return [
            'category.name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name'),
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

    public function create(): void
    {
        $this->validate();

        $this->modal = false;

        try {
            $this->category->save();

            $this->category = new Category();

            $this->emitUp('category::index::refresh');
            $this->notification()->success('Categoria criada com sucesso!');

            return;
        } catch (Exception $e) {
            report($e);
        }

        $this->notification()->error('Erro ao criar categoria!');
    }
}
