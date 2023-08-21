<?php

namespace App\Services\Settings;

use App\Models\Setting;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\LazyCollection;

class SettingsService
{
    public function all(): LazyCollection
    {
        return Setting::all()
            ->lazy()
            ->mapWithKeys(fn (Setting $setting) => [$setting->key => $this->get($setting->key)]);
    }

    public function get(string $key, mixed $default = null): ?string
    {
        $default = $default instanceof Closure ? $default() : $default;
        $key     = strtoupper($key);

        $get = Cache::rememberForever("settings::{$key}", function () use ($key, $default) {
            return Setting::firstWhere('key', '=', $key)?->value ?? $default;
        });

        return $get ? $this->parse($get) : null;
    }

    public function set(string $key, mixed $value, string $type = 'string'): Setting
    {
        Cache::forget("settings::{$key}");

        return Setting::updateOrCreate([
            'key' => strtoupper($key),
        ], [
            'value' => $value,
            'type'  => $type,
        ]);
    }

    private function parse(string $result): string
    {
        if (!str($result)->contains('%')) {
            return $result;
        }

        preg_match_all('/\{%(.*?)%\}/', $result, $matches);

        if (empty($matches[1])) {
            return $result;
        }

        foreach ($matches[1] as $match) {
            $result = str_replace(
                "{%{$match}%}",
                $this->get($match),
                $result
            );
        }

        return $result;
    }
}
