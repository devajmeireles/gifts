<?php

namespace App\Exports\Item;

use App\Models\{Category, Item, Signature};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping};

class ItemExport implements FromCollection, WithMapping, WithHeadings
{
    public function __construct(
        protected readonly ?int $category = null
    ) {
        //
    }

    public function collection(): Collection
    {
        return Item::with(['category', 'signatures'])
            ->when($this->category, fn (Builder $query) => $query->where('category_id', '=', $this->category))
            ->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Nome',
            'Categoria',
            'Descrição',
            'Referência',
            'Quantidade',
            'Assinados',
            'Preço',
            'Status',
            'Cotável',
            'Criado',
            'Atualizado',
        ];
    }

    public function map($row): array
    {
        /** @var Item $row */
        return [
            $row->id,
            $row->name,
            $row->category->name,
            $row->description ?? 'N/A',
            $row->reference,
            $row->quantity,
            $row->signatures->count(),
            $row->price,
            $row->is_active ? 'Ativado' : 'Desativado',
            $row->is_quotable ? 'Sim' : 'Não',
            $row->created_at->format('d/m/Y H:i:s'),
            $row->updated_at->format('d/m/Y H:i:s'),
        ];
    }
}
