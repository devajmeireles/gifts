<div>
    <x-select.styled :$label
                     :request="[
                       'route'  => route('search.item'),
                       'params' => ['category' => $category, 'active' => $active],
                     ]" {{ $attributes }} />
</div>
