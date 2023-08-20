<?php

use App\Http\Livewire\Setting\Update;
use App\Models\Setting;
use App\Services\Settings\Facades\Settings;

use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can update', function () {
    $key   = 'TITULO_EVENTO';
    $value = 'Evento de teste';

    $setting = Setting::factory()->create(['key' => $key]);

    livewire(Update::class, ['setting' => $setting])
        ->set('setting.value', $value)
        ->call('update')
        ->assertHasNoErrors();

    expect(Settings::get($key))->toBe($value);
});
