<?php

namespace App\Exports\Traits;

trait Makeable
{
    public static function make(...$parameters): self
    {
        if (is_array($parameters[0])) {
            $parameters = $parameters[0];
        }

        return new static(...$parameters);
    }
}
