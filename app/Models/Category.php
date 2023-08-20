<?php

namespace App\Models;

use App\Enums\Category\Badge;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\{Builder, Model};

/**
 * @mixin IdeHelperCategory
 */
class Category extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'description',
        'color',
        'is_active',
    ];

    protected $casts = [
        'color'     => Badge::class,
        'is_active' => 'boolean',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('is_active', '=', true);
    }
}
