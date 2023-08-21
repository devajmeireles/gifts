<?php

namespace App\Models;

use App\Enums\DeliveryType;
use App\Models\Traits\{HasAvatar, Searchable};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Builder, Model};

/**
 * @mixin IdeHelperSignature
 */
class Signature extends Model
{
    use HasFactory;
    use Searchable;
    use HasAvatar;

    protected $fillable = [
        'name',
        'phone',
        'delivery',
        'observation',
    ];

    protected $casts = [
        'delivery' => DeliveryType::class,
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function scopeCountGroupByInRange(Builder $query, string $startDate, string $endDate): Builder
    {
        return $query->selectRaw("DATE(created_at) as date, count(*) as total")
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date');

    }

}
