<?php

namespace App\Services\Settings;

use App\Models\Setting;
use Closure;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    public function get(string $key, mixed $default = null): mixed
    {
        $default = $default instanceof Closure ? $default() : $default;

        return Cache::rememberForever("settings::{$key}", function () use ($key, $default) {
            return Setting::firstWhere('key', '=', $key)?->value ?? $default;
        });
    }

    public function set(string $key, mixed $value): Setting
    {
        Cache::forget("settings::{$key}");

        return Setting::updateOrCreate([
            'key' => strtoupper($key),
        ], [
            'value' => $value,
        ]);
    }
}
