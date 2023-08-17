<?php

namespace App\Models;

use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'is_quotable',
        'is_active',
        'signed_at',
    ];

    protected $casts = [
        'is_quotable' => 'boolean',
        'is_active'   => 'boolean',
        'signed_at'   => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
