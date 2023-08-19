<?php

use App\Models\Item;

use function Pest\Laravel\get;

beforeEach(fn () => createTestUser());

it('can search', function () {
    $item = Item::factory()
        ->create();

    get(route('api.search.item'))
        ->assertJson([
            [
                'id'   => $item->id,
                'name' => $item->name,
            ],
        ]);
});

it('cannot search inactive', function () {
    Item::factory()
        ->inactivated()
        ->create();

    get(route('api.search.item'))
        ->assertJson([]);
});

it('cannot search empty', function () {
    get(route('api.search.item'))
        ->assertJson([]);
});
