<?php

namespace App\Services\Settings\Facades;

use App\Services\Settings\SettingsService;
use Illuminate\Support\Facades\Facade;

class Settings extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SettingsService::class;
    }
}
