<?php

namespace App\Actions\Signature;

use App\Enums\DeliveryType;
use App\Models\{Item, Presence, Signature};
use App\Services\Settings\Facades\Settings;
use Exception;
use Illuminate\Support\Collection;
use Throwable;

class CreateSignature
{
    /** @throws Exception|Throwable */
    public function execute(Item $item, Signature $signature, int $quantity = 1): bool
    {
        $this->validations($item, $quantity);

        $presence = $this->presence($signature);

        $item->signatures()
            ->createMany(Collection::times($quantity, fn () => array_merge($signature->toArray(), $presence))->toArray());

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

    private function presence(Signature $signature): array
    {
        if (!Settings::get('converter_assinaturas_em_presenca') && $signature->delivery !== DeliveryType::InPerson) {
            return [];
        }

        $presence = Presence::create([
            'name'         => $signature->name,
            'phone'        => $signature->phone,
            'is_confirmed' => true,
            'observation'  => 'Presença criada via assinatura',
        ]);

        return ['presence_id' => $presence->id];
    }
}
