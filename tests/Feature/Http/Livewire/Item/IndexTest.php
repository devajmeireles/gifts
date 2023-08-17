<?php

use App\Http\Livewire\Item\{Delete, Index, Update};
use App\Models\Item;

use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can render component', function () {
    $this->get(route('items'))
        ->assertSeeLivewire(Index::class);
});

it('can list items', function () {
    $item = Item::factory()
        ->forCategory()
        ->create();

    livewire(Index::class)
        ->assertSee($item->name)
        ->assertSee($item->category->name);
});

it('can paginate items', function () {
    $item = Item::factory(2)
        ->forCategory()
        ->create();

    $one = $item->first();
    $two = $item->last();

    livewire(Index::class, ['quantity' => 1])
        ->assertSee($one->name)
        ->assertDontSee($two->name);

    livewire(Index::class, ['quantity' => 1, 'page' => 2])
        ->assertDontSee($one->name)
        ->assertSee($two->name);
});

it('can change quantity', function () {
    $one = Item::factory()
        ->forCategory()
        ->create([
            'name' => 'First Item',
        ]);

    $two = Item::factory()
        ->forCategory()
        ->create([
            'name' => 'Second Item',
        ]);

    livewire(Index::class, ['quantity' => 1])
        ->assertSee($one->name)
        ->assertDontSee($two->name)
        ->set('quantity', 2)
        ->assertSee($two->name);
});

it('can sort items', function () {
    $one = Item::factory()
        ->forCategory()
        ->create(['name' => 'A']);

    $two = Item::factory()
        ->forCategory()
        ->create(['name' => 'B']);

    livewire(Index::class, ['sort' => 'name', 'direction' => 'asc'])
        ->assertSeeInOrder([$one->name, $two->name])
        ->set('direction', 'desc')
        ->assertSeeInOrder([$two->name, $one->name]);
});

it('can load item method', function (array $data) {
    $method = $data['method'];
    $event  = $data['event']['class'];
    $name   = $data['event']['name'];

    $item = Item::factory()
        ->forCategory()
        ->create();

    livewire(Index::class)
        ->call($method, $item)
        ->assertEmittedTo($event, $name, $item);
})->with([
    fn () => [
        'method' => 'update',
        'event'  => [
            'class' => Update::class,
            'name'  => 'item::update::load',
        ],
    ],
    fn () => [
        'method' => 'delete',
        'event'  => [
            'class' => Delete::class,
            'name'  => 'item::delete::load',
        ],
    ],
]);
