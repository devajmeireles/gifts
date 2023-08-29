<?php

use App\Http\Livewire\Signature\Delete;
use App\Models\{Item, Signature};
use App\Services\Settings\Facades\Settings;

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseEmpty};
use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can delete', function () {
    $signature = Signature::factory()
        ->forItem()
        ->forPresence()
        ->create();

    assertDatabaseCount('presences', 1);

    livewire(Delete::class, ['signature' => $signature])
        ->call('delete')
        ->assertHasNoErrors();

    assertDatabaseEmpty('signatures');
    assertDatabaseCount('presences', 1);
});

it('can delete reactivating item', function () {
    $item = Item::factory()
        ->inactivated()
        ->create();

    $signature = Signature::factory()
        ->for($item)
        ->create();

    livewire(Delete::class, ['signature' => $signature])
        ->call('delete')
        ->assertHasNoErrors();

    assertDatabaseEmpty('signatures');

    expect(($item = $item->refresh())->is_active)
        ->toBeTrue()
        ->and($item->last_signed_at)
        ->toBeNull();
});

it('can delete and delete presence', function () {
    Settings::shouldReceive('get')
        ->with('converter_assinaturas_em_presenca')
        ->once()
        ->andReturnTrue();

    $signature = Signature::factory()
        ->forItem()
        ->forPresence()
        ->create();

    assertDatabaseCount('presences', 1);

    livewire(Delete::class, ['signature' => $signature])
        ->call('delete')
        ->assertHasNoErrors();

    assertDatabaseEmpty('signatures');
    assertDatabaseEmpty('presences');
});
