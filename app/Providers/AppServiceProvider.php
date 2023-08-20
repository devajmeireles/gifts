<?php

namespace App\Providers;

use App\Services\Settings\Facades\Settings;
use App\Services\Settings\SettingsService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        Model::shouldBeStrict(!$this->app->isProduction());

        Password::defaults(function () {
            return Password::min(8)
                ->letters()
                ->numbers()
                ->symbols()
                ->mixedCase();
        });
    }
}
