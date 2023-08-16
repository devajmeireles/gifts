<?php

use App\Http\Livewire\Item\{Index, Update};
use App\Models\{Category, Item};

use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can update item', function () {
    $item = Item::factory()
        ->forCategory()
        ->create();

    $category = Category::factory()->create();

    $name        = fake()->word();
    $description = fake()->sentence();
    $quantity    = fake()->numberBetween(1, 100);
    $reference   = fake()->url();
    $activated   = fake()->boolean();

    livewire(Update::class)
        ->call('load', $item)
        ->set('item.name', $name)
        ->set('item.description', $description)
        ->set('item.category_id', $category->id)
        ->set('item.quantity', $quantity)
        ->set('item.reference', $reference)
        ->set('item.is_active', $activated)
        ->call('update')
        ->assertHasNoErrors()
        ->assertSuccessful()
        ->assertEmittedUp('item::index::refresh');

    $item->refresh();

    expect($item->name)
        ->toBe($name)
        ->and($item->description)
        ->toBe($description)
        ->and($item->category_id)
        ->toBe($category->id)
        ->and($item->quantity)
        ->toBe($quantity)
        ->and($item->reference)
        ->toBe($reference)
        ->and($item->is_active)
        ->toBe($activated);
});

it('cannot update item using name already in use', function () {
    $one = Item::factory()
        ->forCategory()
        ->create();

    $two = Item::factory()
        ->forCategory()
        ->create();

    $category = Category::factory()->create();

    $description = fake()->sentence();
    $quantity    = fake()->numberBetween(1, 100);
    $reference   = fake()->url();
    $activated   = fake()->boolean();

    livewire(Update::class)
        ->call('load', $one)
        ->set('item.name', $two->name)
        ->set('item.description', $description)
        ->set('item.category_id', $category->id)
        ->set('item.quantity', $quantity)
        ->set('item.reference', $reference)
        ->set('item.is_active', $activated)
        ->call('update')
        ->assertHasErrors(['item.name' => 'unique']);

    expect($one->refresh()->name)
        ->not()
        ->toBe($two->name);
});
