<?php

use App\Models\Setting;
use App\Services\Settings\Facades\Settings;

use function Pest\Laravel\assertDatabaseHas;

it('can set', function (string $type) {
    $key   = 'TITULO_EVENTO';
    $value = 'Evento de teste';

    expect(Settings::set($key, $value, $type))
        ->toBeInstanceOf(Setting::class);

    assertDatabaseHas('settings', [
        'key'   => $key,
        'value' => $value,
        'type'  => $type,
    ]);
})->with([
    ['text'],
    ['textarea'],
    ['phone'],
    ['date'],
    ['time'],
]);

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

it('can get subsequently', function () {
    $now = now();

    Settings::set('CONTATO', $phone = '(11) 99999-9999');
    Settings::set('RUA', $street = 'Rua dos Bobos, 0');
    Settings::set('DATA', $now->format('Y-m-d'));
    Settings::set('LOCAL', 'O evento ocorrerá na minha casa ({%rua%}), dia: {%data%}. Se tiver dúvidas de como chegar, ligue para {%contato%}');

    expect(Settings::get('local'))
        ->toBe("O evento ocorrerá na minha casa ($street), dia: {$now->format('d/m/Y')}. Se tiver dúvidas de como chegar, ligue para $phone");
});
