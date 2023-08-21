<?php

namespace App\View\Components\Filter;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Item extends Component
{
    public function __construct(
        public string $label = 'Item',
        public ?string $placeholder = 'Procure um item',
        public bool $active = true,
    ) {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.filter.item');
    }
}
