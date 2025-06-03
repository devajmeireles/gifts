<div wire:key="{{ uniqid() }}">
    <x-select.styled :$label :request="route('search.category')" {{ $attributes }} />
</div>
