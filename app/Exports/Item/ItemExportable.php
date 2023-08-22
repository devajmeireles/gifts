<?php

namespace App\Exports\Item;

use App\Exports\Traits\Makeable;
use Illuminate\Contracts\Support\Arrayable;

class ItemExportable implements Arrayable
{
    use Makeable;

    public function __construct(
        protected readonly ?int $category = null,
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'category' => $this->category,
        ];
    }
}
