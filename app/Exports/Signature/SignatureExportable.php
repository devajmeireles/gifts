<?php

namespace App\Exports\Signature;

use App\Exports\Traits\Makeable;
use Illuminate\Contracts\Support\Arrayable;

class SignatureExportable implements Arrayable
{
    use Makeable;

    public function __construct(
        protected readonly ?int    $category = null,
        protected readonly ?int    $item = null,
        protected readonly ?string $start = null,
        protected readonly ?string $end = null,
    ) {
        //
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
