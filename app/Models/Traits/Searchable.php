<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public function scopeSearch(Builder $query, string $search = null, ...$columns): Builder
    {
        return $query->when(filled($search), function (Builder $query) use ($search, $columns) {
            $query->whereAny(array_values($columns), 'like', '%' . trim($search) . '%');
        });
    }
}
