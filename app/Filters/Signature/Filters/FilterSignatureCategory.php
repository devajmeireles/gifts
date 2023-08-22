<?php

namespace App\Filters\Signature\Filters;

use App\Filters\Traits\ShareableConstructor;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class FilterSignatureCategory
{
    use ShareableConstructor;

    public function handle(Builder $builder, Closure $next): LengthAwarePaginator
    {
        $category = data_get($this->filters, 'category', Cache::get('signature::index::filter')['category'] ?? null);

        $builder->when(
            $category,
            fn (Builder $builder) => $builder->whereHas(
                'item',
                fn (Builder $builder) => $builder->where('category_id', '=', $category)
            )
        );

        return $next($builder);
    }
}
