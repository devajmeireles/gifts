@props(['first' => null, 'label' => null, 'column' => null, 'sort' => null, 'direction' => null])

<th scope="col" {{ $attributes->class([
        'py-3.5 text-left text-sm font-semibold text-gray-900',
        'px-3'              => ! $first,
        'pl-4 pr-3 sm:pl-6' => $first,
    ]) }}>
    <a href="#" class="group inline-flex cursor-pointer truncate text-primary"
       @if ($sort && $column && $direction) wire:click.prevent="sort('{{ $column }}', '{{ $sort === $column ? ($direction === 'asc' ? 'desc' : 'asc') : 'desc' }}')" @endif>

        {{ $label ?? $slot }}
        <span class="ml-2 flex-none rounded">

            @if ($sort === $column && $direction === 'asc')
                <x-heroicon-s-chevron-up class="inline-block w-4 h-4 ml-1 text-primary-700"/>
            @elseif ($sort === $column && $direction === 'desc')
                <x-heroicon-s-chevron-down class="inline-block w-4 h-4 ml-1 text-primary-700"/>
            @endif

            @if ($sort !== $column)
                <x-heroicon-s-chevron-down class="inline-block w-4 h-4 ml-1 text-primary-700"/>
            @endif
        </span>
    </a>
</th>
