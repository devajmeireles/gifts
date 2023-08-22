<x-alert primary outline center>
    <a {{ $attributes }} class="cursor-pointer font-semibold uppercase text-primary">
        {{ $slot->isEmpty() ? 'Clique aqui para exportar o relatório' : $slot }}
    </a>
</x-alert>
