<?php

namespace App\Filters\Signature\Filters;

use App\Filters\Signature\ShareableConstructor;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class FilterSignatureCategory
{
    use ShareableConstructor;

    public function handle(Builder $builder, Closure $next): LengthAwarePaginator
    {
        if (($category = data_get($this->filters, 'category')) !== null) {
            $builder->whereHas(
                'item',
                fn (Builder $builder) => $builder->where('category_id', $category)
            );
        }

        return $next($builder);
    }
}
