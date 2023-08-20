<?php

use App\Http\Livewire\Setting\Index;
use App\Models\Setting;

use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can render component', function () {
    $this->get(route('admin.settings'))
        ->assertSeeLivewire(Index::class);
});

it('can list', function () {
    $setting = Setting::factory()
        ->create();

    livewire(Index::class)->assertSee($setting->key);
});

it('can search', function () {
    $setting = Setting::factory(2)
        ->create();

    $one = $setting->first();
    $two = $setting->last();

    livewire(Index::class)
        ->set('search', $one->key)
        ->assertSee($one->key)
        ->assertDontSee($two->key);

    livewire(Index::class)
        ->set('search', $two->key)
        ->assertSee($two->key)
        ->assertDontSee($one->key);
});

it('can paginate', function () {
    $setting = Setting::factory(2)
        ->create();

    $one = $setting->first();
    $two = $setting->last();

    livewire(Index::class, ['quantity' => 1])
        ->assertSee($one->key)
        ->assertDontSee($two->key);

    livewire(Index::class, ['quantity' => 1, 'page' => 2])
        ->assertDontSee($one->key)
        ->assertSee($two->key);
});

it('can change quantity', function () {
    $one = Setting::factory()
        ->create(['key' => 'First Item']);

    $two = Setting::factory()
        ->create(['key' => 'Second Item']);

    livewire(Index::class, ['quantity' => 1])
        ->assertSee($one->key)
        ->assertDontSee($two->key)
        ->set('quantity', 2)
        ->assertSee($two->key);
});

it('can sort', function () {
    $one = Setting::factory()
        ->create(['key' => 'A']);

    $two = Setting::factory()
        ->create(['key' => 'B']);

    livewire(Index::class, ['sort' => 'key', 'direction' => 'asc'])
        ->assertSeeInOrder([$one->key, $two->key])
        ->set('direction', 'desc')
        ->assertSeeInOrder([$two->key, $one->key]);
});
