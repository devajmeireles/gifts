<?php

namespace App\Filters\Signature\Filters;

use App\Filters\Traits\ShareableConstructor;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class FilterSignatureItem
{
    use ShareableConstructor;

    public function handle(Builder $builder, Closure $next): LengthAwarePaginator
    {
        $item = data_get($this->filters, 'item', Cache::get('signature::index::filter')['item'] ?? null);

        $builder->when($item, fn (Builder $builder) => $builder->where('item_id', '=', $item));

        return $next($builder);
    }
}
