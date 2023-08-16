<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Traits\Conditionable;

trait Searchable
{
    use Conditionable;

    public function scopeSearch(Builder $query, string $search = null, array $columns = ['*'])
    {
        return $query->when($search, function (Builder $query) use ($search, $columns) {
            $search  = trim($search);
            $collect = collect($columns);

            $query->where($collect->first(), 'like', '%' . $search . '%');

            $this->when($collect->count() > 1, function () use ($collect, $query, $search) {
                foreach ($collect->except([0])->values()->toArray() as $column) {
                    $query->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        });
    }
}
