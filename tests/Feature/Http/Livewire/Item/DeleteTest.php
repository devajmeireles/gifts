<?php

use App\Http\Livewire\Item\{Delete, Index};
use App\Models\Item;

use function Pest\Laravel\assertModelMissing;
use function Pest\Livewire\livewire;

it('can delete item', function () {
    createTestUser();

    $item = Item::factory()
        ->forCategory()
        ->create();

    livewire(Delete::class)
        ->call('load', $item)
        ->assertDispatchedBrowserEvent('wireui:confirm-notification')
        ->call('delete')
        ->assertEmittedUp('item::index::refresh');

    assertModelMissing($item);
});
