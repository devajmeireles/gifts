<?php

namespace App\View\Components\Filter;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Category extends Component
{
    public function __construct(
        public string $label = 'Categoria',
        public ?string $placeholder = 'Procure uma categoria'
    ) {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.filter.category');
    }
}
