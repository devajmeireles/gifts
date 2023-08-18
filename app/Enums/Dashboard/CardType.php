<?php

namespace App\Enums\Dashboard;

enum CardType: int
{
    case AllItems       = 1;
    case ItemsSigned    = 2;
    case ItemsNotSigned = 3;

    public function translate(): string
    {
        return __('app.dashboard.card.' . $this->value);
    }
}
