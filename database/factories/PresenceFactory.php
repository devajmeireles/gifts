<?php

namespace Database\Factories;

use App\Models\Presence;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Presence>
 */
class PresenceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'         => $this->faker->name(),
            'phone'        => $this->faker->phoneNumber(),
            'is_confirmed' => $this->faker->boolean(),
        ];
    }

    public function confirmed(): self
    {
        return $this->state(['is_confirmed' => true]);
    }

    public function unconfirmed(): self
    {
        return $this->state(['is_confirmed' => false]);
    }
}
