<?php

use App\Http\Livewire\Signature\Filter;
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
    $category = Category::factory()
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
