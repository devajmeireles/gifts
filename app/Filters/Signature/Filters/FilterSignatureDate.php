<?php

namespace App\Filters\Signature\Filters;

use App\Filters\Signature\ShareableConstructor;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class FilterSignatureDate
{
    use ShareableConstructor;

    public function handle(Builder $builder, Closure $next): LengthAwarePaginator
    {
        $start = data_get($this->filters, 'start');
        $end   = data_get($this->filters, 'end');

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
