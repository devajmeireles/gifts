<?php

namespace App\Services\Settings\Facades;

use App\Models\Setting;
use App\Services\Settings\SettingsService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed get(string $key, mixed $default = null)
 * @method static Setting set(string $key, mixed $value, string $type = 'string')
 * @see SettingsService
 */
class Settings extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SettingsService::class;
    }
}
