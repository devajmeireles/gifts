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
        ->assertDispatchedBrowserEvent('wireui:confirm-notification')
        ->call('delete')
        ->assertEmittedUp('category::index::refresh');

    assertModelMissing($category);
});

it('can warning when category is in use', function () {
    $category = Category::factory()->create();

    Item::factory()
        ->for($category)
        ->create();

    $component = livewire(Delete::class)
        ->call('load', $category);

    expect(data_get($component->payload, 'effects.dispatches.0.data.options'))
        ->toBe([
            'title'       => '1 itens vinculados a esta categoria!',
            'description' => 'Deseja realmente deletar esta categoria?',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Sim!',
                'method' => 'delete',
            ],
        ]);
});

it('can delete and detach item', function () {
    $category = Category::factory()->create();

    $item = Item::factory()
        ->for($category)
        ->create();

    livewire(Delete::class)
        ->call('load', $category)
        ->assertDispatchedBrowserEvent('wireui:confirm-notification')
        ->call('delete')
        ->assertEmittedUp('category::index::refresh');

    assertModelMissing($category);

    expect($item->category)->toBeNull();
});
