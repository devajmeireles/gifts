<?php

use App\Http\Livewire\Item\Create;

use App\Models\{Category, Item};

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseHas};
use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can create', function () {
    $name        = fake()->word();
    $description = fake()->sentence();
    $category    = Category::factory()->create()->id;
    $quantity    = fake()->numberBetween(1, 100);
    $reference   = fake()->url();
    $quotable    = fake()->boolean();
    $activated   = fake()->boolean();

    livewire(Create::class)
        ->set('item.name', $name)
        ->set('item.description', $description)
        ->set('item.category_id', $category)
        ->set('item.quantity', $quantity)
        ->set('item.reference', $reference)
        ->set('item.is_quotable', $quotable)
        ->set('item.is_active', $activated)
        ->call('create')
        ->assertHasNoErrors()
        ->assertSuccessful()
        ->assertEmittedUp('item::index::refresh');

    assertDatabaseHas('items', [
        'name'        => $name,
        'description' => $description,
        'category_id' => $category,
        'quantity'    => $quantity,
        'reference'   => $reference,
        'is_quotable' => $quotable,
        'is_active'   => $activated,
    ]);
});

it('cannot create with name already in use', function () {
    $item = Item::factory()
        ->forCategory()
        ->create();

    $description = fake()->sentence();
    $category    = Category::factory()->create()->id;
    $quantity    = fake()->numberBetween(1, 100);
    $reference   = fake()->url();
    $activated   = fake()->boolean();

    livewire(Create::class)
        ->set('item.name', $item->name)
        ->set('item.description', $description)
        ->set('item.category_id', $category)
        ->set('item.quantity', $quantity)
        ->set('item.reference', $reference)
        ->set('item.is_active', $activated)
        ->call('create')
        ->assertHasErrors(['item.name' => 'unique']);

    assertDatabaseCount('items', 1);
});
