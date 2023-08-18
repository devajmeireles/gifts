<?php

namespace App\Enums;

use App\Enums\Traits\ToArray;

enum DeliveryType: int
{
    use ToArray;

    case Locally = 1;
    case Remote  = 2;

    public static function toSelect(): array
    {
        return collect(DeliveryType::cases())
            ->map(
                fn (DeliveryType $value) => [
                    'id'    => $value->value,
                    'label' => __('app.delivery_type.' . strtolower($value->name)),
                ]
            )
            ->toArray();
    }
}
