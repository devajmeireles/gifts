<?php

namespace App\Actions\Signature;

use App\Models\{Item, Signature};
use Exception;
use Illuminate\Support\Collection;
use Throwable;

class CreateSignature
{
    /** @throws Exception|Throwable */
    public function execute(Item $item, Signature $signature, int $quantity = 1): bool
    {
        $this->validations($item, $quantity);

        $item->signatures()
            ->createMany(Collection::times($quantity, fn () => $signature->toArray())->toArray());

        $item->is_active      = $item->available();
        $item->last_signed_at = now();
        $item->save();

        return true;
    }

    /** @throws Exception|Throwable */
    private function validations(Item $item, int $quantity = 1): void
    {
        throw_if(!$item->is_active, new Exception("Item ({$item->id}) não está ativo"));

        throw_if($quantity > $item->availableQuantity(), new Exception("Quantidade selecionada ($quantity) é superior a quantidade de itens ({$item->quantity})"));
    }
}
