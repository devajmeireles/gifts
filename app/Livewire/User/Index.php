<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = [
        'user::index::refresh' => '$refresh',
    ];

    public function render(): View
    {
        return view('livewire.user.index', [
            'users' => $this->data(),
        ]);
    }

    private function data(): LengthAwarePaginator
    {
        return User::query()
            ->where('id', '!=', user()->id)
            ->search($this->search, 'name', 'username')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->quantity);
    }
}
