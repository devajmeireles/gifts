<?php

namespace App\Exports\Signature;

use App\Models\Signature;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping};

class SignatureExport implements FromCollection, WithMapping, WithHeadings
{
    public function __construct(
        protected SignatureExportable $exportable
    ) {
        //
    }

    public function collection(): Collection
    {
        $data = $this->exportable->toArray();

        $category = data_get($data, 'category');
        $item     = data_get($data, 'item');
        $start    = data_get($data, 'start');
        $end      = data_get($data, 'end');

        return Signature::with('item.category')
            ->when($category, fn ($query) => $query->where('category_id', '=', $category))
            ->when($item, fn ($query) => $query->where('item_id', '=', $item))
            ->when($start, fn ($query) => $query->whereDate('created_at', '>=', $start))
            ->when($end, fn ($query) => $query->whereDate('created_at', '<=', $end))
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

    public function map($row): array
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
