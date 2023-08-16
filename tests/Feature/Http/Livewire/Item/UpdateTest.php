<?php

use App\Http\Livewire\Item\Index;
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

    livewire()

    $update->assertPayloadSet('item', $item->toArray());
});
