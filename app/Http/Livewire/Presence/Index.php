<?php

namespace App\Http\Livewire\Presence;

use App\Http\Livewire\Traits\Table;
use App\Models\Presence;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class Index extends Component
{
    use Table;

    protected $listeners = [
        'presence::index::refresh' => '$refresh',
    ];

    public function render(): View
    {
        return view('livewire.presence.index', [
            'presences' => $this->data(),
        ]);
    }

    private function data(): LengthAwarePaginator
    {
        return Presence::withCount('signatures')
            ->search($this->search, 'name', 'phone')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->quantity);
    }

    public function update(Presence $presence): void
    {
        $this->emitTo(Update::class, 'presence::update::load', $presence);
    }
}
