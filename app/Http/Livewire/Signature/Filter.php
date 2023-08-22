<?php

namespace App\Http\Livewire\Signature;

use App\Exports\Signature\{SignatureExport, SignatureExportable};
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use WireUi\Traits\Actions;

class Filter extends Component
{
    use Actions;

    public bool $modal = false;

    public bool $filtered = false;

    public int $count = 0;

    public ?int $category = null;

    public ?int $item = null;

    public ?string $start = null;

    public ?string $end = null;

    public function render(): View
    {
        return view('livewire.signature.filter');
    }

    public function updatedModal(): void
    {
        if (!$this->modal) {
            $this->category = null;
        }
    }

    public function filter(): void
    {
        $this->modal = false;

        $this->count = collect([
            $this->category,
            $this->item,
            $this->start,
            $this->end,
        ])->filter()->count();

        if ($this->count === 0) {
            $this->notification()->error('Ops!', 'Selecione ao menos um filtro.');

            return;
        }

        $this->emitUp('signature::index::filter', [
            'category' => $this->category,
            'item'     => $this->item,
            'start'    => $this->start,
            'end'      => $this->end,
        ]);

        $this->filtered = true;
    }

    public function clear(): void
    {
        $this->category = null;
        $this->item     = null;
        $this->start    = null;
        $this->end      = null;

        $this->filtered = false;
        $this->count    = 0;

        $this->emitUp('signature::index::refresh');
    }

    public function export(): BinaryFileResponse
    {
        $file = sprintf('assinaturas-%s.xlsx', now()->format('Y-m-d_H:i:s'));

        return Excel::download(
            new SignatureExport(SignatureExportable::make([
                'category' => $this->category,
                'item'     => $this->item,
                'start'    => $this->start,
                'end'      => $this->end,
            ])),
            $file
        );
    }
}
