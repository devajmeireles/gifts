<?php

namespace App\Models;

use App\Enums\DeliveryType;
use App\Models\Traits\{HasAvatar, Searchable};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

/**
 * @mixin IdeHelperSignature
 */
class Signature extends Model
{
    use HasFactory;
    use Searchable;
    use HasAvatar;

    protected $fillable = [
        'presence_id',
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

    public function presence(): BelongsTo
    {
        return $this->belongsTo(Presence::class);
    }
}
