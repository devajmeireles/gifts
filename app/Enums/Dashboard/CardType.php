<?php

namespace App\Enums\Dashboard;

enum CardType: int
{
    case AllItems         = 1;
    case AllSignedItems   = 2;
    case AllUnsignedItems = 3;

    public function translate(): string
    {
        return __('app.dashboard.card.' . $this->value);
    }
}
