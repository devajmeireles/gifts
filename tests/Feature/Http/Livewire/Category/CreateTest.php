<?php

use App\Http\Livewire\Category\Create;

use App\Models\Category;

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseHas};
use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can create', function () {
    $name        = fake()->word();
    $color       = 'default';
    $description = fake()->sentence();
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

it('can validate successfully', function () {
    livewire(Create::class)
        ->set('category.name', fake()->words(300, true))
        ->set('category.description', fake()->words(300, true))
        ->set('color', 'asd')
        ->call('create')
        ->assertHasErrors([
            'category.name'        => 'max',
            'category.description' => 'max',
            'color'                => 'in',
        ]);
});
