<?php

namespace App\Filters\Signature;

trait ShareableConstructor
{
    public function __construct(
        protected array $filters
    ) {
        //
    }
}
