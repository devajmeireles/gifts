@props([
    'green'  => null,
    'red'    => null,
    'blue'   => null,
    'yellow' => null,
    'gray'   => null,

    'center' => null,
])

@php
    $type = 'indigo';

    if ($green) $type = 'green';
    if ($red) $type = 'red';
    if ($blue) $type = 'blue';
    if ($yellow) $type = 'yellow';
    if ($gray) $type = 'gray';
@endphp

<div @class([
    'rounded-md p-4',
    'bg-green-100'   => $type === 'green',
    'bg-red-100'     => $type === 'red',
    'bg-blue-100'    => $type === 'blue',
    'bg-yellow-100'  => $type === 'yellow',
    'bg-gray-100'    => $type === 'gray',
    'bg-indigo-100'  => $type === 'indigo',
])>
    <div @class([
        'flex',
        'justify-center' => $center,
    ])>
        <div class="ml-3">
            <p class="text-sm font-medium text-{{ $type }}-800">
                {{ $slot }}
            </p>
        </div>
    </div>
</div>
