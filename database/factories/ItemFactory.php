<?php

namespace Database\Factories;

use App\Models\{Category, Item};
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name'        => $this->faker->text(15),
            'description' => $this->faker->sentence(),
            'reference'   => $this->faker->word(),
            'quantity'    => $this->faker->numberBetween(1, 10),
        ];
    }

    public function activated(): self
    {
        return $this->state(['is_active' => true]);
    }

    public function inactivated(): self
    {
        return $this->state(['is_active' => false]);
    }

    public function quotable(): self
    {
        return $this->state(['is_quotable' => true]);
    }

    public function signed(Carbon $carbon = null): self
    {
        return $this->state(['last_signed_at' => $carbon ?? $this->faker->dateTimeBetween('-1 year', 'now')]);
    }
}
