<?php

namespace App\Providers;

use App\Services\Settings\Facades\Settings;
use App\Services\Settings\SettingsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            Settings::class,
            fn () => $this->app->make(SettingsService::class)
        );
    }

    public function boot(): void
    {
        auth()->loginUsingId(1);
    }
}
