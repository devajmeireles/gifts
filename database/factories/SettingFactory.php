<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Setting>
 */
class SettingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'key' => str($this->faker->unique()->sentence(3))
                ->upper()
                ->value(),
            'value' => $this->faker->text(),
        ];
    }
}
