<?php

namespace App\Console\Commands;

use App\Services\Settings\Facades\Settings;
use Illuminate\Console\Command;

use function Laravel\Prompts\{confirm, select, text};

class CreateSettingCommand extends Command
{
    protected $signature = 'make:setting';

    protected $description = 'Create new application setting';

    public function handle(): int
    {
        $key   = text('What will be the setting key?', required: true);
        $value = text('What will be the setting value?', required: true);
        $key   = strtoupper($key);
        $type  = select(
            'What will be the setting type?',
            options: [
                'text'     => 'text',
                'textarea' => 'textarea',
                'date'     => 'date',
                'time'     => 'time',
                'phone'    => 'phone (text, masked)',
                'boolean'  => 'boolean',
            ]
        );

        Settings::set($key, $value, $type);

        $this->components->info("Setting <bg=red>{$key}</> created successfully!");

        if (confirm('Do you want to create another setting?')) {
            $this->handle();
        }

        return self::SUCCESS;
    }
}
