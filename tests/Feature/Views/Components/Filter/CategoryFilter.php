<?php

use App\Models\Category;

use function Pest\Laravel\get;

beforeEach(fn () => createTestUser());

it('can search', function () {
    $category = Category::factory()
        ->activated()
        ->create();

    get(route('api.search.category'))
        ->assertJson([
            [
                'id'   => $category->id,
                'name' => $category->name,
            ],
        ]);
});

it('cannot search inactive', function () {
    Category::factory()
        ->inactivated()
        ->create();

    get(route('api.search.category'))
        ->assertJson([]);
});

it('cannot search empty', function () {
    get(route('api.search.category'))
        ->assertJson([]);
});
