<?php

namespace App\Http\Livewire\Setting;

use App\Http\Livewire\Traits\Table;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class Index extends Component
{
    use Table;

    public function render(): View
    {
        return view('livewire.setting.index', [
            'settings' => $this->data(),
        ]);
    }

    private function data(): LengthAwarePaginator
    {
        return Setting::query()
            ->search($this->search, ['key', 'value'])
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->quantity);
    }
}
