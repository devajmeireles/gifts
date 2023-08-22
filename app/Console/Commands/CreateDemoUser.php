<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\{error, spin};

use Throwable;

class CreateDemoUser extends Command
{
    protected $signature = 'demo';

    protected $description = 'Create demo user';

    public function handle(): int
    {
        if (!config('app.demo')) {
            error('Demo mode is disabled.');

            return self::FAILURE;
        }

        spin(function () {
            try {
                User::create([
                    'role'     => UserRole::Admin,
                    'name'     => 'demo',
                    'username' => 'demo',
                    'password' => Hash::make('demo'),
                ]);

                return true;
            } catch (Throwable $e) {
                error("Error: {$e->getMessage()}");

                return false;
            }
        }, 'Creating...');

        $this->components->info("User <bg=red>demo</> created successfully!");

        return self::SUCCESS;
    }
}
