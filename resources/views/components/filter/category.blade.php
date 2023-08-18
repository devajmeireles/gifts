<div>
    <x-select label="{{ $label }}"
              placeholder="{{ $placeholder }}"
              :async-data="route('api.search.category')"
              option-label="name"
              option-value="id"
              {{ $attributes }}
    />
</div>
