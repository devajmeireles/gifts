<?php

namespace App\Enums;

use App\Enums\Traits\{Selectable, ToArray};
use App\Services\Settings\Facades\Settings;

enum DeliveryType: int
{
    use ToArray;
    use Selectable;

    case InPerson = 1;
    case Remotely = 2;

    public function thankYou(): string
    {
        return match ($this) {
            self::InPerson => Settings::get('recebimento_evento'),
            self::Remotely => Settings::get('recebimento_remotamente'),
        };
    }

    public function tip(): string
    {
        return match ($this) {
            self::InPerson => __('app.delivery_type.tip.in_person'),
            self::Remotely => __('app.delivery_type.tip.remotely'),
        };
    }
}
