<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;

trait HasAvatar
{
    public function avatar(): string
    {
        $model = static::class;

        return Cache::rememberForever(
            "$model::avatar::{$this->id}::{$this->name}",
            fn () => "https://ui-avatars.com/api/?name={$this->name}&background=e63f66&color=fff"
        );
    }
}
