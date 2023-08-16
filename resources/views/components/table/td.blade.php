@props(['first' => null, 'buttons' => null])

<td {{ $attributes->class([
        'whitespace-nowrap py-4 text-sm',
        'pl-4 pr-3 font-medium text-gray-900 sm:pl-6'       => $first,
        'px-3 text-gray-500'                                => ! $buttons,
        'relative pl-3 pr-4 text-right font-medium sm:pr-6' => $buttons
    ]) }}>
    {{ $slot }}
</td>
