@props([
    'green'   => null,
    'primary' => null,
])

@php
    $icon     = $green ? 'plus' : 'arrow-left';
    $position = $green ? 'bottom-2' : 'bottom-14';
@endphp

<button {{ $attributes->class([
        'rounded-full p-2 text-4xl text-white drop-shadow-lg duration-300 z-90',
        'fixed right-4 flex h-10 w-10 items-center justify-center',
        'bottom-2 bg-primary'    => $primary,
        'bottom-14 bg-green-500' => $green,
    ]) }} {{ $attributes->only('wire:click') }}>
    <x-dynamic-component :component="'heroicon-s-'.$icon" {{ $attributes->except('wire:click') }} />
</button>
