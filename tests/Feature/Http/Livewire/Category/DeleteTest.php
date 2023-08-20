<?php

use App\Http\Livewire\Category\Delete;

use App\Models\{Category, Item};

use function Pest\Laravel\assertModelMissing;
use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can delete', function () {
    $category = Category::factory()->create();

    livewire(Delete::class)
        ->call('load', $category)
        ->assertDispatchedBrowserEvent('wireui:confirm-dialog')
        ->call('delete')
        ->assertEmittedUp('category::index::refresh');

    assertModelMissing($category);
});

test('warning when category is in use', function () {
    $category = Category::factory()->create();

    Item::factory()
        ->for($category)
        ->create();

    $component = livewire(Delete::class)
        ->call('load', $category);

    expect(data_get($component->payload, 'effects.dispatches.0.data.options'))
        ->toBe([
            'icon'        => 'info',
            'title'       => 'Itens vinculados a categoria!',
            'description' => 'Remova os itens da categoria antes de poder deletá-la!',
        ]);
});
