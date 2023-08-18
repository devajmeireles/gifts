<?php

namespace App\Http\Livewire\Signature;

use App\Http\Livewire\Traits\Table;
use App\Models\Signature;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class Index extends Component
{
    use Table;

    protected $listeners = [
        'signature::index::refresh' => '$refresh'
    ];

    public function render(): View
    {
        return view('livewire.signature.index', [
            'signatures' => $this->data(),
        ]);
    }

    private function data(): LengthAwarePaginator
    {
        return Signature::with('item')
            ->search($this->search, ['name', 'phone'])
            ->orderBy($this->sort, $this->direction)
            ->paginate(12);
    }
}
