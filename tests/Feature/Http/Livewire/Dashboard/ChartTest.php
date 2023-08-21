<?php

use App\Http\Livewire\Dashboard\Chart;
use App\Models\{Item, Signature};

use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can view chart', function (int $quantity) {
    $items = Item::factory($quantity)
        ->activated()
        ->create();

    $items->each(function (Item $item) {
        Signature::factory()
            ->for($item)
            ->create();
    });

    livewire(Chart::class)
        ->call('load')
        ->assertSee((string) $quantity);
})->with([
    [150],
    [50],
    [350],
]);
