<?php

use App\Http\Livewire\Signature\{Filter, Index};
use App\Models\{Category, Item, Signature};

use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can filter by item', function () {
    $item = Item::factory()
        ->activated()
        ->create();

    livewire(Filter::class)
        ->set('item', $item->id)
        ->call('filter')
        ->assertEmittedUp('signature::index::filter', [
            'category' => null,
            'item'     => $item->id,
            'start'    => null,
            'end'      => null,
        ]);
});

it('can filter by category', function () {
    $category = Category::factory()
        ->activated()
        ->create();

    livewire(Filter::class)
        ->set('category', $category->id)
        ->call('filter')
        ->assertEmittedUp('signature::index::filter', [
            'category' => $category->id,
            'item'     => null,
            'start'    => null,
            'end'      => null,
        ]);
});

it('can filter by date', function () {
    Category::factory()
        ->activated()
        ->create();

    $start = now()->subDays(5)->format('Y-m-d');
    $end   = now()->addDays(5)->format('Y-m-d');

    livewire(Filter::class)
        ->set('start', $start)
        ->set('end', $end)
        ->call('filter')
        ->assertEmittedUp('signature::index::filter', [
            'category' => null,
            'item'     => null,
            'start'    => $start,
            'end'      => $end,
        ]);
});

it('cannot filter using zero filters', function () {
    livewire(Filter::class)
        ->call('filter')
        ->assertDispatchedBrowserEvent('wireui:notification')
        ->assertNotEmitted('signature::index::filter');
});

it('can view filtered by item', function () {
    $one = Item::factory()
        ->forCategory()
        ->activated()
        ->create();

    $two = Item::factory()
        ->activated()
        ->create();

    Signature::factory()
        ->for($one)
        ->create();

    Signature::factory()
        ->for($two)
        ->create();

    livewire(Index::class)
        ->call('filter', [
            'item' => $one->id,
        ])
        ->assertSee($one->name)
        ->assertDontSee($two->name);
});

it('can view filtered by category', function () {
    $one = Item::factory()
        ->for($category = Category::factory()->activated()->create())
        ->activated()
        ->create();

    $two = Item::factory()
        ->activated()
        ->create();

    Signature::factory()
        ->for($one)
        ->create();

    Signature::factory()
        ->for($two)
        ->create();

    livewire(Index::class)
        ->call('filter', [
            'category' => $category->id,
        ])
        ->assertSee($one->name)
        ->assertDontSee($two->name);
});

it('can view filtered by dates', function () {
    $one = Item::factory()
        ->for($category = Category::factory()->activated()->create())
        ->activated()
        ->create();

    $two = Item::factory()
        ->activated()
        ->create();

    Signature::factory()
        ->for($one)
        ->create([
            'created_at' => now()->subDays(10),
        ]);

    Signature::factory()
        ->for($two)
        ->create([
            'created_at' => now()->addDays(5),
        ]);

    livewire(Index::class)
        ->call('filter', [
            'start' => now()->subDays(10)->format('Y-m-d'),
            'end'   => now()->subDays(1)->format('Y-m-d'),
        ])
        ->assertSee($one->name)
        ->assertDontSee($two->name);
});
