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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
