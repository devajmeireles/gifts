<?php

use App\Models\Setting;
use App\Services\Settings\Facades\Settings;

use function Pest\Laravel\assertDatabaseHas;

it('can set', function () {
    $key   = 'TITULO_EVENTO';
    $value = 'Evento de teste';

    expect(Settings::set($key, $value))
        ->toBeInstanceOf(Setting::class);

    assertDatabaseHas('settings', [
        'key'   => $key,
        'value' => $value,
    ]);
});

it('can get', function () {
    $setting = Setting::factory()
        ->create();

    expect(Settings::get($setting->key))
        ->toBe($setting->value);
});

it('can get using default', function () {
    $key   = 'TITULO_EVENTO';
    $value = 'Evento de teste';

    expect(Settings::get($key, fn () => $value))
        ->toBe($value);
});

it('can mock', function () {
    Settings::shouldReceive('get')
        ->with('foo')
        ->andReturn('bar');

    expect(Settings::get('foo'))
        ->toBe('bar');
});
