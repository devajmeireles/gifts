<?php

namespace App\Actions\Signature;

use App\Models\{Item, Signature};
use App\Notifications\SignatureCreated;
use Exception;
use Illuminate\Support\Collection;
use Throwable;

class CreateSignature
{
    /** @throws Exception|Throwable */
    public function execute(Item $item, Signature $signature, int $quantity = 1): bool
    {
        $this->validations($item, $signature, $quantity);

        $item->signatures()
            ->createMany(Collection::times($quantity, fn () => $signature->toArray())->toArray());

        if ($item->signatures()->count() === $item->quantity) {
            $item->is_active = false;
        }

        $item->last_signed_at = now();
        $item->save();
        $item->notify(new SignatureCreated($item, $signature, $quantity));

        return true;
    }

    /** @throws Exception|Throwable */
    private function validations(Item $item, Signature $signature, int $quantity = 1): void
    {
        throw_if(!$item->is_active, new Exception("Item ({$item->id}) não está ativo"));

        throw_if($quantity > $item->availableQuantity(), new Exception("Quantidade selecionada ($quantity) é superior a quantidade de itens ({$item->quantity})"));
    }
}
