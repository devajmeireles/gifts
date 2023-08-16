<?php

use App\Http\Livewire\Item\Index;
use App\Http\Livewire\Item\Update;
use App\Models\Item;
use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can load item', function () {
    $item = Item::factory()
        ->forCategory()
        ->create();

    $name = fake()->word();
    $description = fake()->sentence();
    $category = $item->category_id;
    $quantity = fake()->numberBetween(1, 100);
    $reference = fake()->url();
    $activated = fake()->boolean();

    livewire(Update::class)
        ->call('load', $item)
        ->set('item.name', $name)
        ->set('item.description', $description)
        ->set('item.category_id', $category)
        ->set('item.quantity', $quantity)
        ->set('item.reference', $reference)
        ->set('item.is_active', $activated)
        ->call('update')
        ->assertHasNoErrors()
        ->assertSuccessful()
        ->assertEmittedUp('item::index::refresh');

    $update->assertPayloadSet('item', $item->toArray());
});
