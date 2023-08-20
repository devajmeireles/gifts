<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\{Hash, Process};

use function Laravel\Prompts\{error, password, spin, text};

use Throwable;

class SetupCommand extends Command
{
    protected $signature = 'setup';

    protected $description = 'Initial setup for the application';

    public function handle(): int
    {
        $this->setup();

        $this->components->info('Access the application by clicking here: ' . route('admin.login'));

        return self::SUCCESS;
    }

    private function setup(): void
    {
        $name     = text('What will be the root user name?', required: true);
        $nick     = text('What will be the root username?', default: str($name)->snake()->value(), required: true);
        $password = password('What will be the root password?', required: true);

        spin(function () {
            sleep(1);

            try {
                Process::run(['php', 'artisan', 'migrate', '--step']);
            } catch (Throwable $e) {
                error('Ops!' . $e->getMessage());
            }
        }, 'Migrating database...');

        spin(function () use ($name, $nick, $password) {
            sleep(1);

            try {
                User::factory()
                    ->admin()
                    ->create([
                        'name'     => $name,
                        'username' => $nick,
                        'password' => Hash::make($password),
                    ]);
            } catch (Throwable $e) {
                error('Ops!' . $e->getMessage());
            }
        }, 'Creating root...');
    }
}
