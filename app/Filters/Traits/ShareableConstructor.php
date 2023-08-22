<?php

namespace App\Filters\Traits;

trait ShareableConstructor
{
    public function __construct(
        protected array $filters
    ) {
        //
    }
}
