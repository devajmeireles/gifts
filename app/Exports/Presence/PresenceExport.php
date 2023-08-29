<?php

namespace App\Exports\Presence;

use App\Models\Presence;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping};

class PresenceExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection(): Collection
    {
        return Presence::with('signatures')->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Nome',
            'Telefone',
            'Confirmado',
            'Assinatura',
            'Criado',
            'Atualizado',
        ];
    }

    public function map(mixed $row): array
    {
        /** @var Presence $row */
        return [
            $row->id,
            $row->name,
            $row->phone,
            $row->is_confirmed ? 'Sim' : 'Não',
            $row->signatures?->first()->id ?? 'N/A',
            $row->created_at->format('d/m/Y H:i:s'),
            $row->updated_at->format('d/m/Y H:i:s'),
        ];
    }
}
