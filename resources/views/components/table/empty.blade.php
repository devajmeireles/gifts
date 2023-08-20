<x-table.tr>
    <x-table.td colspan="12">
        {{ $slot->isEmpty() ? "Nenhum registro encontrado." : $slot }}
    </x-table.td>
</x-table.tr>
