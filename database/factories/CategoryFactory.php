<?php

namespace Database\Factories;

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
            'name'        => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'is_active'   => $this->faker->boolean(),
        ];
    }

    public function activated(): self
    {
        return $this->state(['is_active' => true]);
    }
}
