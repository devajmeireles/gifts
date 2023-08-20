<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\{password, select, spin, text};

class CreateUserCommand extends Command
{
    protected $signature = 'make:user';

    protected $description = 'Create new user';

    public function handle(): int
    {
        $name     = text('What will be the user name?', required: true);
        $nick     = text('What will be the username?', default: str($name)->snake()->value(), required: true);
        $password = password('What will be the password?', required: true);

        $role = select(
            'What will be the role?',
            collect(UserRole::cases())
                ->mapWithKeys(fn (UserRole $role) => [
                    $role->value => $role->name,
                ])
        );

        spin(fn () => User::factory()
            ->create([
                'role'     => $role,
                'name'     => $name,
                'username' => $nick,
                'password' => Hash::make($password),
            ]), 'Creating user...');

        $this->components->info("User <bg=red>{$name}</> created successfully!");

        return self::SUCCESS;
    }
}
