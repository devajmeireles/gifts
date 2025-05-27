<?php

namespace App\Providers;

use App\Services\Settings\SettingsService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('settings', fn () => $this->app->make(SettingsService::class));
    }

    public function boot(): void
    {
        $this->configureHttps();

        $this->configureModel();

        $this->configurePassword();

    }

    private function configureHttps(): void
    {
        URL::forceHttps($this->app->isProduction());
    }

    private function configureModel(): void
    {
        Model::automaticallyEagerLoadRelationships();

        Model::shouldBeStrict(!$this->app->isProduction());
    }

    private function configurePassword(): void
    {
        Password::defaults(function () {
            return Password::min(8)
                ->letters()
                ->numbers()
                ->mixedCase();
        });
    }
}
