<?php

namespace App\Models;

use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany};

/**
 * @mixin IdeHelperPresence
 */
class Presence extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'phone',
        'is_confirmed',
        'observation',
    ];

    protected $casts = [
        'is_confirmed' => 'boolean',
    ];

    public function signatures(): HasMany
    {
        return $this->hasMany(Signature::class);
    }
}
