<?php

namespace App\Http\Livewire\Signature;

use App\Filters\Signature\Filters\{FilterSignatureCategory, FilterSignatureDate, FilterSignatureItem};
use App\Http\Livewire\Traits\Table;
use App\Models\Signature;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Pipeline;
use Livewire\Component;

class Index extends Component
{
    use Table;

    protected $listeners = [
        'signature::index::refresh' => '$refresh',
        'signature::index::filter'  => 'filter',
    ];

    protected array $filters = [];

    public function render(): View
    {
        return view('livewire.signature.index', [
            'signatures' => $this->data(),
        ]);
    }

    public function filter(array $filters): void
    {
        $this->filters = [...$filters];
    }

    private function data(): LengthAwarePaginator
    {
        return Pipeline::send(Signature::with('item.signatures'))
            ->through([
                new FilterSignatureCategory($this->filters),
                new FilterSignatureItem($this->filters),
                new FilterSignatureDate($this->filters),
            ])
            ->then(
                fn (Builder $builder) => $builder->search($this->search, 'name', 'phone') // @phpstan-ignore-line
                    ->orderBy($this->sort, $this->direction)
                    ->paginate(12)
            );
    }
}
