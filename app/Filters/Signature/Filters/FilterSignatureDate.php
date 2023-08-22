<?php

namespace App\Filters\Signature\Filters;

use App\Filters\Traits\ShareableConstructor;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class FilterSignatureDate
{
    use ShareableConstructor;

    public function handle(Builder $builder, Closure $next): LengthAwarePaginator
    {
        $start = data_get($this->filters, 'start', Cache::get('signature::index::filter')['start'] ?? null);
        $end   = data_get($this->filters, 'end', Cache::get('signature::index::filter')['end'] ?? null);

        $builder->when(
            $start,
            fn (Builder $builder) => $builder->where(
                'created_at',
                '>=',
                now()->parse($start)
            )
        );

        $builder->when(
            $end,
            fn (Builder $builder) => $builder->where(
                'created_at',
                '<=',
                now()->parse($end)
            )
        );

        return $next($builder);
    }
}
