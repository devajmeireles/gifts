<?php

use App\Http\Livewire\Item\{Index, Update};
use App\Models\{Category, Item, Signature};

use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can update', function () {
    $item = Item::factory()
        ->forCategory()
        ->activated()
        ->create();

    $category = Category::factory()->create();

    $name        = fake()->word();
    $description = fake()->sentence();
    $quantity    = fake()->numberBetween($item->quantity + 2, 100);
    $price       = fake()->numberBetween(1, 100);
    $reference   = fake()->url();
    $quotable    = fake()->boolean();
    $activated   = fake()->boolean();

    livewire(Update::class)
        ->call('load', $item)
        ->set('item.name', $name)
        ->set('item.description', $description)
        ->set('item.category_id', $category->id)
        ->set('item.quantity', $quantity)
        ->set('item.price', $price)
        ->set('item.reference', $reference)
        ->set('item.is_quotable', $quotable)
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
        ->toBe($activated)
        ->and($item->is_quotable)
        ->toBe($quotable);
});

it('can update and inactivate item due signature quantity', function () {
    $item = Item::factory()
        ->quotable(10)
        ->forCategory()
        ->activated()
        ->create();

    Signature::factory(10)
        ->for($item)
        ->create();

    $category = Category::factory()->create();

    $name        = fake()->word();
    $description = fake()->sentence();
    $price       = fake()->numberBetween(1, 100);
    $reference   = fake()->url();
    $quotable    = fake()->boolean();

    livewire(Update::class)
        ->call('load', $item)
        ->set('item.name', $name)
        ->set('item.description', $description)
        ->set('item.category_id', $category->id)
        ->set('item.quantity', 10)
        ->set('item.price', $price)
        ->set('item.reference', $reference)
        ->set('item.is_quotable', $quotable)
        ->call('update')
        ->assertHasNoErrors()
        ->assertSuccessful()
        ->assertEmittedUp('item::index::refresh');

    expect($item->is_active)->toBeTrue();

    $item->refresh();

    expect($item->is_active)->toBeFalse();
});

it('can update and inactivate item due quantity increase', function () {
    $item = Item::factory()
        ->quotable(10)
        ->forCategory()
        ->inactivated()
        ->create();

    Signature::factory(10)
        ->for($item)
        ->create();

    $category = Category::factory()->create();

    $name        = fake()->word();
    $description = fake()->sentence();
    $price       = fake()->numberBetween(1, 100);
    $reference   = fake()->url();
    $quotable    = fake()->boolean();

    livewire(Update::class)
        ->call('load', $item)
        ->set('item.name', $name)
        ->set('item.description', $description)
        ->set('item.category_id', $category->id)
        ->set('item.quantity', 11)
        ->set('item.price', $price)
        ->set('item.reference', $reference)
        ->set('item.is_quotable', $quotable)
        ->call('update')
        ->assertHasNoErrors()
        ->assertSuccessful()
        ->assertEmittedUp('item::index::refresh');

    expect($item->is_active)->toBeFalse();

    $item->refresh();

    expect($item->is_active)->toBeTrue();
});

it('can update and activate item due signature removed', function () {
    $item = Item::factory()
        ->quotable(10)
        ->forCategory()
        ->inactivated()
        ->create();

    $signature = Signature::factory(10)
        ->for($item)
        ->create()
        ->first();

    $signature->delete();

    $category = Category::factory()->create();

    $name        = fake()->word();
    $description = fake()->sentence();
    $price       = fake()->numberBetween(1, 100);
    $reference   = fake()->url();
    $quotable    = fake()->boolean();

    livewire(Update::class)
        ->call('load', $item)
        ->set('item.name', $name)
        ->set('item.description', $description)
        ->set('item.category_id', $category->id)
        ->set('item.price', $price)
        ->set('item.reference', $reference)
        ->set('item.is_quotable', $quotable)
        ->call('update')
        ->assertHasNoErrors()
        ->assertSuccessful()
        ->assertEmittedUp('item::index::refresh');

    expect($item->is_active)->toBeFalse();

    $item->refresh();

    expect($item->is_active)->toBeTrue();
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

it('cannot update decreasing the quantity to be less than signatures', function () {
    $item = Item::factory()
        ->forCategory()
        ->create(['quantity' => 5]);

    Signature::factory(5)
        ->for($item)
        ->create();

    $name        = fake()->word();
    $description = fake()->sentence();
    $price       = fake()->numberBetween(1, 100);
    $reference   = fake()->url();
    $quotable    = fake()->boolean();
    $activated   = fake()->boolean();

    livewire(Update::class)
        ->call('load', $item)
        ->set('item.name', $name)
        ->set('item.description', $description)
        ->set('item.category_id', $item->category_id)
        ->set('item.quantity', 4)
        ->set('item.price', $price)
        ->set('item.reference', $reference)
        ->set('item.is_quotable', $quotable)
        ->set('item.is_active', $activated)
        ->call('update')
        ->assertDispatchedBrowserEvent('wireui:notification');

    $item->refresh();

    expect($item->quantity)->toBe(5);
});
