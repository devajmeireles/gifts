<?php

namespace App\Exports\Signature;

use App\Models\{Category, Item, Signature};
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class SignatureExport implements FromCollection
{
    public function __construct(
        protected readonly ?Category $category = null,
        protected readonly ?Item $item = null,
        protected readonly ?string $start = null,
        protected readonly ?string $end = null,
    ) {
        //
    }

    public function collection(): Collection
    {
        return Signature::with(['item.category'])
            ->when($this->category, fn ($query) => $query->where('category_id', '=', $this->category->id))
            ->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Item',
            'Categoria',
            'Assinante',
            'Telefone',
            'Entrega',
            'Observação',
            'Criado',
        ];
    }

    public function map($row): array
    {
        /** @var Signature $row */
        return [
            $row->id,
            $row->item->name,
            $row->item->category->name,
            $row->name,
            $row->phone,
            $row->delivery->translate(),
            $row->observation ?? 'N/A',
            $row->created_at->format('d/m/Y H:i:s'),
        ];
    }
}
