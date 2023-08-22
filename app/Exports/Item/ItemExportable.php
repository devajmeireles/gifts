<?php

namespace App\Exports\Item;

use App\Models\{Category, Item};
use Illuminate\Contracts\Support\Arrayable;

class ItemExportable implements Arrayable
{
    public function __construct(
        protected readonly ?Item $item = null,
    ) {
        //
    }

    public static function make(...$parameters): self
    {
        return new static(...$parameters);
    }

    public function toArray(): array
    {
        return [
            'item' => $this->item,
        ];
    }
}
