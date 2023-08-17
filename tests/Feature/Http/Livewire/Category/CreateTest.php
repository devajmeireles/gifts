<?php

use App\Http\Livewire\Category\Create;

use App\Models\Category;

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseHas};
use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can create', function () {
    $name        = fake()->word();
    $description = fake()->sentence();
    $color       = 'default';
    $activated   = fake()->boolean();

    livewire(Create::class)
        ->set('category.name', $name)
        ->set('category.description', $description)
        ->set('color', $color)
        ->set('category.is_active', $activated)
        ->call('create')
        ->assertHasNoErrors()
        ->assertSuccessful()
        ->assertEmittedUp('category::index::refresh');

    assertDatabaseHas('categories', [
        'name'        => $name,
        'description' => $description,
        'color'       => $color,
        'is_active'   => $activated,
    ]);
});

it('cannot create with name already in use', function () {
    $category = Category::factory()->create();

    $description = fake()->sentence();
    $color       = 'default';
    $activated   = fake()->boolean();

    livewire(Create::class)
        ->set('category.name', $category->name)
        ->set('category.description', $description)
        ->set('color', $color)
        ->set('category.is_active', $activated)
        ->call('create')
        ->assertHasErrors(['category.name' => 'unique']);

    assertDatabaseCount('categories', 1);
});
