<?php

namespace App\Models;

use App\Enums\DeliveryType;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

/**
 * @mixin IdeHelperSignature
 */
class Signature extends Model
{
    use HasFactory;
    use Searchable;

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

    public function avatar(): string
    {
        return Cache::rememberForever(
            "avatar::{$this->id}::{$this->name}",
            fn () => "https://ui-avatars.com/api/?name={$this->name}&background=5850EC&color=fff"
        );
    }
}
