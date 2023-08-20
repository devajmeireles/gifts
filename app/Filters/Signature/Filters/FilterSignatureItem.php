<?php

namespace App\Filters\Signature\Filters;

use App\Filters\Signature\ShareableConstructor;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class FilterSignatureItem
{
    use ShareableConstructor;

    public function handle(Builder $builder, Closure $next): LengthAwarePaginator
    {
        if (($item = data_get($this->filters, 'item')) !== null) {
            $builder->where('item_id', '=', $item);
        }

        return $next($builder);
    }
}
