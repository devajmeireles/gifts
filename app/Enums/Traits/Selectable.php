<?php

namespace App\Enums\Traits;

use App\Enums\{DeliveryType, UserRole};

trait Selectable
{
    public static function toSelect(): array
    {
        return collect(self::cases())
            ->map(
                fn (self $case) => [
                    'id'    => $case->value,
                    'label' => self::label($case),
                ]
            )
            ->toArray();
    }

    private static function label(self $case): string
    {
        return match (self::class) {
            DeliveryType::class => __('app.delivery_type.' . strtolower($case->name)),
            UserRole::class     => __('app.user.role.' . $case->value),
        };
    }
}
