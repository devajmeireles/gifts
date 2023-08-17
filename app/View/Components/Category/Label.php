<?php

namespace App\View\Components\Category;

use App\Models\{Category, Item};
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Label extends Component
{
    public function __construct(
        protected Item|Category $model
    ) {
        //
    }

    public function render(): View|Closure|string
    {
        $category = $this->model instanceof Category;

        $color = $category
            ? $this->model->color->value
            : $this->model->category->color->value;

        $label = $category
            ? $this->model->name
            : $this->model->category->name;

        return <<<blade
<div>
    <x-badge outline color="$color" label="$label" />
</div>
blade;
    }
}
