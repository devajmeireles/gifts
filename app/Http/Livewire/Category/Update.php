<?php

namespace App\Http\Livewire\Category;

use App\Enums\Category\Badge;
use App\Models\Category;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use WireUi\Traits\Actions;

class Update extends Component
{
    use Actions;

    public ?Category $category = null;

    public bool $modal = false;

    public ?string $color = null;

    public function mount(): void
    {
        $this->color = $this->category?->color->value;
    }

    public function render(): View
    {
        return view('livewire.category.update', [
            'colors' => collect(Badge::cases()),
        ]);
    }

    public function load(Category $category): void
    {
        $this->category = $category;
        $this->color    = $category->color->value;
        $this->modal    = true;
    }

    public function rules(): array
    {
        return [
            'category.name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')
                    ->ignore($this->category->id),
            ],
            'color' => [
                'required',
                'string',
                Rule::in(Badge::toArray()),
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
            $this->category->color = Badge::from($this->color);
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
