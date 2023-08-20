<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Process;

use function Laravel\Prompts\{error, spin};

use Throwable;

class SetupCommand extends Command
{
    protected $signature = 'setup';

    protected $description = 'Initial setup for the application';

    public function handle(): int
    {
        spin(function () {
            sleep(1);

            try {
                Process::run(['php', 'artisan', 'key:generate']);
            } catch (Throwable $e) {
                error("Error: {$e->getMessage()}");
            }
        }, 'Preparing application...');

        spin(function () {
            sleep(1);

            try {
                Process::run(['php', 'artisan', 'migrate:fresh', '--step']);
            } catch (Throwable $e) {
                error("Error: {$e->getMessage()}");
            }
        }, 'Migrating database...');

        $this->components->info("Use <bg=red>php artisan make:user</> to create the first root user.");
        $this->newLine();
        $this->components->info('Access the application by clicking here: ' . route('admin.login'));

        return self::SUCCESS;
    }
}
