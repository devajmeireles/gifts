<?php

namespace App\Enums;

use App\Enums\Traits\{Selectable, ToArray};

enum DeliveryType: int
{
    use ToArray;
    use Selectable;

    case Locally = 1;
    case Remote  = 2;
}
