<?php

use App\Http\Livewire\Category\Delete;

use App\Models\Category;

use function Pest\Laravel\assertModelMissing;
use function Pest\Livewire\livewire;

it('can delete', function () {
    createTestUser();

    $category = Category::factory()->create();

    livewire(Delete::class)
        ->call('load', $category)
        ->assertDispatchedBrowserEvent('wireui:confirm-notification')
        ->call('delete')
        ->assertEmittedUp('category::index::refresh');

    assertModelMissing($category);
});
