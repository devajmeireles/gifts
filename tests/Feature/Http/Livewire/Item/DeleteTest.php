<?php

use App\Http\Livewire\Item\{Delete};
use App\Models\Item;

use function Pest\Laravel\assertModelMissing;
use function Pest\Livewire\livewire;

it('can delete', function () {
    createTestUser();

    $item = Item::factory()
        ->forCategory()
        ->create();

    livewire(Delete::class)
        ->call('load', $item)
        ->assertDispatchedBrowserEvent('wireui:confirm-dialog')
        ->call('delete');

    assertModelMissing($item);
});
