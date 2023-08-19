<?php

use App\Enums\Category\Badge;
use App\Http\Livewire\Category\Update;
use App\Models\{Category, Item};

use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can update', function () {
    $category = Category::factory()->create();

    $name        = fake()->word();
    $description = fake()->sentence();
    $color       = 'white';
    $activated   = fake()->boolean();

    livewire(Update::class)
        ->call('load', $category)
        ->set('category.name', $name)
        ->set('category.description', $description)
        ->set('color', $color)
        ->assertSet('color', $color)
        ->set('category.is_active', $activated)
        ->call('update')
        ->assertHasNoErrors()
        ->assertSuccessful()
        ->assertEmittedUp('category::index::refresh');

    $category->refresh();

    expect($category->name)
        ->toBe($name)
        ->and($category->description)
        ->toBe($description)
        ->and($category->color)
        ->toBeInstanceOf(Badge::class)
        ->and($category->color)
        ->toBe(Badge::from($color))
        ->and($category->is_active)
        ->toBe($activated);
});

it('cannot update using name already in use', function () {
    $one = Category::factory()->create();
    $two = Category::factory()->create();

    $description = fake()->sentence();
    $color       = 'white';
    $activated   = fake()->boolean();

    livewire(Update::class)
        ->call('load', $one)
        ->set('category.name', $two->name)
        ->set('category.description', $description)
        ->set('color', $color)
        ->set('category.is_active', $activated)
        ->call('update')
        ->assertHasErrors(['category.name' => 'unique']);

    expect($one->refresh()->name)
        ->not()
        ->toBe($two->name);
});

it('can validate successfully', function () {
    $category = Category::factory()->create();

    livewire(Update::class)
        ->call('load', $category)
        ->set('category.name', fake()->words(300, true))
        ->set('category.description', fake()->words(300, true))
        ->set('color', 'asd')
        ->call('update')
        ->assertHasErrors([
            'category.name'        => 'max',
            'category.description' => 'max',
            'color'                => 'in',
        ]);
});
