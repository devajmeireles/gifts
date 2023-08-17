<x-table.tr>
    <x-table.td colspan="6">
        {{ $slot->isEmpty() ? "Nenhum registro encontrado." : $slot }}
    </x-table.td>
</x-table.tr>
