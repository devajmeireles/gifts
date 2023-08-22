<?php

namespace App\Exports\Signature;

use App\Models\{Category, Item};
use Illuminate\Contracts\Support\Arrayable;

class SignatureExportable implements Arrayable
{
    public function __construct(
        protected readonly ?Category $category = null,
        protected readonly ?Item     $item = null,
        protected readonly ?string   $start = null,
        protected readonly ?string   $end = null,
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
            'category' => $this->category,
            'item'     => $this->item,
            'start'    => $this->start,
            'end'      => $this->end,
        ];
    }
}
