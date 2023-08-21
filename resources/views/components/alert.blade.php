@props([
    'green'   => null,
    'red'     => null,
    'blue'    => null,
    'yellow'  => null,
    'gray'    => null,
    'outline' => null,
    'center'  => null,
    'justify' => null,
])

@php
    $type = 'primary';

    if ($green) $type = 'green';
    if ($red) $type = 'red';
    if ($blue) $type = 'blue';
    if ($yellow) $type = 'yellow';
    if ($gray) $type = 'gray';
    if ($outline) $type = 'outline';
@endphp

<div @class([
    'rounded-md p-4',
    'bg-green-100'       => $type === 'green',
    'bg-red-100'         => $type === 'red',
    'bg-blue-100'        => $type === 'blue',
    'bg-yellow-100'      => $type === 'yellow',
    'bg-gray-100'        => $type === 'gray',
    'bg-primary-100'     => $type === 'primary',
    'border'             => $type === 'outline',
    'border-green-100'   => $type === 'outline' && $green,
    'border-red-100'     => $type === 'outline' && $red,
    'border-blue-100'    => $type === 'outline' && $blue,
    'border-yellow-100'  => $type === 'outline' && $yellow,
    'border-gray-100'    => $type === 'outline' && $gray,
    'border-primary'     => $type === 'outline' && $outline,
    'border-2'           => $type === 'outline',
])>
    <div @class([
        'flex',
        'justify-center' => $center,
    ])>
        <div class="ml-3">
            <p @class([
                'text-sm font-medium',
                'text-center'      => $center,
                'text-justify'     => $justify,
                'text-green-800'   => $type === 'green',
                'text-red-800'     => $type === 'red',
                'text-blue-800'    => $type === 'blue',
                'text-yellow-800'  => $type === 'yellow',
                'text-gray-800'    => $type === 'gray',
                'text-primary-800' => $type === 'primary',
                'text-green-600'   => $type === 'outline' && $green,
                'text-red-600'     => $type === 'outline' && $red,
                'text-blue-600'    => $type === 'outline' && $blue,
                'text-yellow-600'  => $type === 'outline' && $yellow,
                'text-gray-600'    => $type === 'outline' && $gray,
                'text-primary-600' => $type === 'outline' && $outline,
            ])>
                {{ $slot }}
            </p>
        </div>
    </div>
</div>
