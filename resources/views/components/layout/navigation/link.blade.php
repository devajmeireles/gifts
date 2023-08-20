@props([
    'label',
    'route',
    'icon'   => null,
    'active' => false,
])

<li>
    <a href="{{ $route }}" {{ $attributes->class([
            'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition',
            'text-primary hover:bg-primary-100' => !$active,
            'bg-primary text-white' => $active,
        ]) }}>
        @if ($icon)
            @svg('heroicon-s-' . $icon, 'h-6 w-6 shrink-0' . ($active ? ' text-white' : ' text-primary-600'))
        @endif
        {{ $label ?? $slot }}
    </a>
</li>
