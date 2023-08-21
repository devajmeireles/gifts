<?php

namespace App\Actions\Signature;

use App\Models\{Item, Signature};
use App\Notifications\SignatureCreated;
use Exception;
use Illuminate\Support\Collection;

class CreateSignature
{
    /** @throws Exception */
    public function execute(Item $item, Signature $signature, int $quantity = 1): bool
    {
        if ($quantity > $item->availableQuantity()) {
            throw new Exception("Quantidade selecionada ($quantity) é superior a quantidade de itens ({$item->quantity})");
        }

        $item->signatures()
            ->createMany(Collection::times($quantity, fn () => $signature->toArray())->toArray());

        if ($item->signatures()->count() === $item->quantity) {
            $item->is_active = false;
        }

        $item->last_signed_at = now();
        $item->save();

        user()->notify(new SignatureCreated($item, $signature, $quantity));

        return true;
    }
}
