<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateDevelopmentUser extends Command
{
    protected $signature = 'make:dev';

    protected $description = 'Create a random dev user';

    public function handle(): int
    {
        $name     = fake()->name();
        $nickname = fake()->userName();

        User::create([
            'role'     => UserRole::Admin,
            'name'     => $name,
            'username' => $nickname,
            'password' => Hash::make('password'),
        ]);

        $this->table(
            ['Name', 'Username', 'Password'],
            [[$name, $nickname, 'password']]
        );

        return self::SUCCESS;
    }
}
