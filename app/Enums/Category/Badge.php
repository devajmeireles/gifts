<?php

namespace App\Enums\Category;

use App\Enums\Traits\ToArray;

enum Badge: string
{
    use ToArray;

    case Default   = 'default';
    case Primary   = 'primary';
    case Secondary = 'secondary';
    case Positive  = 'positive';
    case Negative  = 'negative';
    case Warning   = 'warning';
    case Info      = 'info';
    case Dark      = 'dark';
    case White     = 'white';
    case Black     = 'black';
    case Slate     = 'slate';
    case Gray      = 'gray';
    case Zinc      = 'zinc';
    case Neutral   = 'neutral';
    case Stone     = 'stone';
    case Red       = 'red';
    case Orange    = 'orange';
    case Amber     = 'amber';
    case Lime      = 'lime';
    case Green     = 'green';
    case Emerald   = 'emerald';
    case Teal      = 'teal';
    case Cyan      = 'cyan';
    case Sky       = 'sky';
    case Blue      = 'blue';
    case Indigo    = 'indigo';
    case Violet    = 'violet';
    case Purple    = 'purple';
    case Fuchsia   = 'fuchsia';
    case Pink      = 'pink';
    case Rose      = 'rose';
}
