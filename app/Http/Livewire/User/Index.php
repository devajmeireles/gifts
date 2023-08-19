<?php

namespace App\Http\Livewire\User;

use App\Http\Livewire\Traits\Table;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class Index extends Component
{
    use Table;

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
            ->search($this->search, ['name', 'username'])
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->quantity);
    }
}
