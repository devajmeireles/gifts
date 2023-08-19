<?php

namespace Database\Factories;

use App\Enums\Category\Badge;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->text(15),
            'description' => $this->faker->sentence(),
            'color'       => $this->faker->randomElement(Badge::toArray()),
            'is_active'   => $this->faker->boolean(),
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
}
