<?php

use App\Http\Livewire\Signature\Delete;
use App\Models\{Item, Signature};

use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can delete', function () {
    $signature = Signature::factory()
        ->forItem()
        ->create();

    livewire(Delete::class, ['signature' => $signature])
        ->call('delete')
        ->assertHasNoErrors();

    assertDatabaseEmpty('signatures');
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
