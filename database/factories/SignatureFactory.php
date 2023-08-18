<?php

namespace Database\Factories;

use App\Enums\DeliveryType;
use App\Models\{Item, Signature};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Signature>
 */
class SignatureFactory extends Factory
{
    public function definition(): array
    {
        return [
            'item_id'     => Item::factory(),
            'name'        => $this->faker->name(),
            'phone'       => $this->faker->phoneNumber(),
            'delivery'    => $this->faker->randomElement(DeliveryType::toArray()),
            'observation' => $this->faker->sentence(),
        ];
    }
}
