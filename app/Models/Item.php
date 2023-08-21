<?php

namespace App\Models;

use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Notifications\Notifiable;

/**
 * @mixin IdeHelperItem
 */
class Item extends Model
{
    use HasFactory;
    use Searchable;
    use Notifiable;

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
        'quantity'       => 'integer',
        'price'          => 'decimal:2',
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
        return number_format((float) $this->price, 2, ',', '.');
    }

    public function signed(): bool
    {
        return !$this->is_active && !is_null($this->last_signed_at) && $this->signatures->count() >= $this->quantity;
    }

    public function available(): bool
    {
        return $this->signatures->count() < $this->quantity;
    }

    public function availableQuantity(): int
    {
        return ($this->quantity - $this->signatures->count());
    }

    public function quotePrice(bool $realQuantity = true): string
    {
        return number_format(round(($this->price / ($realQuantity ? $this->availableQuantity() : $this->quantity))), 2, ',', '.');
    }

    public function priceQuoted(int $quantity, bool $realQuantity = true): string
    {
        return number_format((($this->price / ($realQuantity ? $this->availableQuantity() : $this->quantity) * $quantity)), 2, ',', '.');
    }

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('is_active', '=', true);
    }
}
