<?php

namespace App\View\Components\Category;

use App\Models\Item;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Label extends Component
{
    public function __construct(
        protected Item $item
    ) {
        //
    }

    public function render(): View|Closure|string
    {
        $color = $this->item->category->is_active ? 'green' : 'red';
        $label = $this->item->category->name;

        return <<<blade
<div>
    <x-badge color="$color" label="$label" />
</div>
blade;
    }
}
