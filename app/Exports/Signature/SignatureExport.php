<?php

namespace App\Exports\Signature;

use App\Models\Signature;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping};

class SignatureExport implements FromCollection, WithMapping, WithHeadings
{
    public function __construct(
        protected readonly ?int    $category = null,
        protected readonly ?int    $item = null,
        protected readonly ?string $start = null,
        protected readonly ?string $end = null,
    ) {
        //
    }

    public function collection(): Collection
    {
        return Signature::with('item.category')
            ->when(
                $this->category,
                fn (Builder $query) => $query->whereHas(
                    'item',
                    fn (Builder $query) => $query->where('category_id', '=', $this->category)
                )
            )
            ->when($this->item, fn (Builder $query) => $query->where('item_id', '=', $this->item))
            ->when($this->start, fn (Builder $query) => $query->whereDate('created_at', '>=', $this->start))
            ->when($this->end, fn (Builder $query) => $query->whereDate('created_at', '<=', $this->end))
            ->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Item',
            'Categoria',
            'Cotável',
            'Preço da Cota',
            'Assinante',
            'Telefone',
            'Entrega',
            'Observação',
            'Criado',
        ];
    }

    public function map(mixed $row): array
    {
        /** @var Signature $row */
        return [
            $row->id,
            $row->item->name,
            $row->item->category->name,
            $row->item->is_quotable ? 'Sim' : 'Não',
            $row->item->is_quotable ? $row->item->quotePrice(false) : 'N/A',
            $row->name,
            blank($row->phone) ? 'N/A' : $row->phone,
            $row->delivery->translate(),
            $row->observation ?? 'N/A',
            $row->created_at->format('d/m/Y H:i:s'),
        ];
    }
}
