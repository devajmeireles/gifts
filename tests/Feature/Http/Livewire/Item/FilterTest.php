<?php

use App\Http\Livewire\Item\{Filter, Index};
use App\Models\{Category, Item};

use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can filter category', function () {
    Item::factory()
        ->for($category = Category::factory()->activated()->create())
        ->activated()
        ->create();

    livewire(Filter::class)
        ->set('category', $category->id)
        ->call('filter')
        ->assertEmittedUp('item::index::filter', [
            'category' => $category->id,
        ]);
});

it('cannot filter using zero filters', function () {
    livewire(Filter::class)
        ->call('filter')
        ->assertDispatchedBrowserEvent('wireui:notification')
        ->assertNotEmitted('item::index::filter');
});

it('can view filtered', function () {
    $one = Item::factory()
        ->for($category = Category::factory()->activated()->create())
        ->activated()
        ->create();

    $two = Item::factory()
        ->activated()
        ->create();

    livewire(Index::class)
        ->call('filter', [
            'category' => $category->id,
        ])
        ->assertSee($one->name)
        ->assertDontSee($two->name);
});
