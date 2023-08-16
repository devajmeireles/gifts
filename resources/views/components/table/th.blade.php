@props(['first' => null, 'label' => null])

<th scope="col" {{ $attributes->class([
        'py-3.5 text-left text-sm font-semibold text-gray-900',
        'px-3'              => ! $first,
        'pl-4 pr-3 sm:pl-6' => $first,
    ]) }}>
    {{ $label ?? $slot }}
</th>
