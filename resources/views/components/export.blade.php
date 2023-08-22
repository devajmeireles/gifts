<x-alert primary outline center>
    <a href="{{ $route }}" class="cursor-pointer font-semibold uppercase text-primary">
        {{ $slot->isEmpty() ? 'Clique aqui para exportar o relatório' : $slot }}
    </a>
</x-alert>
