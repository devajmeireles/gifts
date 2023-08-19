<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'username'          => fake()->unique()->userName(),
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
        ];
    }

    public function role(UserRole $role): self
    {
        return $this->state(['role' => $role]);
    }

    public function admin(): self
    {
        return $this->state(['role' => UserRole::Admin]);
    }

    public function user(): self
    {
        return $this->state(['role' => UserRole::User]);
    }

    public function guest(): self
    {
        return $this->state(['role' => UserRole::Guest]);
    }

    public function unverified(): static
    {
        return $this->state(['email_verified_at' => null]);
    }
}
