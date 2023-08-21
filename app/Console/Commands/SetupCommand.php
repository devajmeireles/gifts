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
        if (app()->isProduction()) {
            error('For safety, this command cannot be executed in production.');

            return self::FAILURE;
        }

        spin(function () {
            try {
                Process::run(['php', 'artisan', 'key:generate']);
            } catch (Throwable $e) {
                error("Error: {$e->getMessage()}");
            }
        }, 'Preparing application...');

        spin(function () {
            try {
                Process::run(['php', 'artisan', 'migrate:fresh', '-seed', '--step']);
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
