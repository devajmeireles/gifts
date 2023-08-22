<?php

namespace App\Exports\Item;

use App\Models\{Category, Item, Signature};
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping};

class ItemExport implements FromCollection, WithMapping, WithHeadings
{
    public function __construct(
        protected readonly ItemExportable $exportable
    ) {
        //
    }

    public function collection(): Collection
    {
        $category = data_get($this->exportable->toArray(), 'category');

        return Signature::with('item.category')
            ->when($category, fn ($query) => $query->where('category_id', '=', $category))
            ->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Categoria',
            'Nome',
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
            $row->category->name,
            $row->name,
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
