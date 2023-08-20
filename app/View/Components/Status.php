<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Status extends Component
{
    public function __construct(
        public bool $status
    ) {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.status', [
            'color' => $this->status ? 'green' : 'red',
            'text'  => $this->status ? 'Ativo' : 'Inativo',
        ]);
    }
}
