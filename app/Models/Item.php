<?php

namespace App\Models;

use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

/**
 * @mixin IdeHelperItem
 */
class Item extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'reference',
        'quantity',
        'price',
        'is_quotable',
        'is_active',
        'last_signed_at',
    ];

    protected $casts = [
        'is_quotable'    => 'boolean',
        'is_active'      => 'boolean',
        'last_signed_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function signatures(): HasMany
    {
        return $this->hasMany(Signature::class);
    }

    public function price(): ?string
    {
        if (!$this->price) {
            return null;
        }

        return number_format($this->price, 2, ',', '.');
    }

    public function available(): bool
    {
        return $this->signatures->count() < $this->quantity;
    }
}
