<?php

namespace App\Providers;

use App\Services\Settings\Facades\Settings;
use App\Services\Settings\SettingsService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
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
        $production = $this->app->isProduction();

        if ($production && str_contains(config('app.url'), 'https')) {
            URL::forceScheme('https');
        }

        Model::shouldBeStrict(!$production);

        Password::defaults(function () {
            return Password::min(8)
                ->letters()
                ->numbers()
                ->mixedCase();
        });
    }
}
