<?php

namespace App\Filters\Item;

use App\Filters\Traits\ShareableConstructor;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class FilterCategoryItem
{
    use ShareableConstructor;

    public function handle(Builder $builder, Closure $next): LengthAwarePaginator
    {
        if (($category = data_get($this->filters, 'category')) !== null) {
            $builder->where('category_id', '=', $category);
        }

        return $next($builder);
    }
}
