<?php

namespace App\Livewire\Category;

use App\Enums\Category\Badge;
use App\Livewire\Traits\Alert;
use App\Models\Category;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class Update extends Component
{
    use Alert;

    public ?Category $category = null;

    public bool $modal = false;

    public ?string $color = null;

    public function render(): View
    {
        return view('livewire.category.update', [
            'colors' => collect(Badge::cases()),
        ]);
    }

    #[On('category::update::load')]
    public function load(Category $category): void
    {
        $this->resetValidation();

        $this->category = $category;
        $this->color    = $category->color->value;
        $this->modal    = true;
    }

    public function rules(): array
    {
        return [
            'category.name'        => ['required', 'string', 'max:255', Rule::unique(Category::class, 'name')->ignore($this->category->id)],
            'color'                => ['required', Rule::in(Badge::toArray())],
            'category.description' => ['nullable', 'max:255'],
            'category.is_active'   => ['nullable', 'boolean'],
        ];
    }

    public function update(): void
    {
        $this->validate();

        $this->modal = false;

        try {
            $this->category->color = Badge::from($this->color);
            $this->category->save();

            $this->dispatch('updated');
            $this->success();

            return;
        } catch (Exception $e) {
            report($e);
        } finally {
            $this->reset();
        }

        $this->error();
    }
}
