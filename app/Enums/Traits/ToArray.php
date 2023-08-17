<?php

namespace App\Enums\Traits;

trait ToArray
{
    public static function toArray(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($value, $key) => [$key => $value->value])
            ->toArray();
    }
}
