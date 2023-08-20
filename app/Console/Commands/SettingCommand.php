<?php

namespace App\Console\Commands;

use App\Services\Settings\Facades\Settings;
use Illuminate\Console\Command;

use function Laravel\Prompts\{confirm, text};

class SettingCommand extends Command
{
    protected $signature = 'make:setting';

    protected $description = 'Create new application setting';

    public function handle(): int
    {
        $this->setting();

        return self::SUCCESS;
    }

    private function setting(): void
    {
        $key   = text('What will be the setting key?', required: true);
        $value = text('What will be the setting value?', required: true);
        $key   = strtoupper($key);

        Settings::set($key, $value);

        $this->components->info("Setting {$key} created successfully!");

        if (confirm('Do you want to create another setting?')) {
            $this->setting();
        }
    }
}
