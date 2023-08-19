<?php

use App\Http\Livewire\Category\{Delete, Index, Update};
use App\Models\Category;

use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can render component', function () {
    $this->get(route('admin.categories'))
        ->assertSeeLivewire(Index::class);
});

it('can list', function () {
    $category = Category::factory()
        ->create();

    livewire(Index::class)->assertSee($category->name);
});

it('can paginate', function () {
    $category = Category::factory(2)
        ->create();

    $one = $category->first();
    $two = $category->last();

    livewire(Index::class, ['quantity' => 1])
        ->assertSee($one->name)
        ->assertDontSee($two->name);

    livewire(Index::class, ['quantity' => 1, 'page' => 2])
        ->assertDontSee($one->name)
        ->assertSee($two->name);
});

it('can change quantity', function () {
    $one = Category::factory()
        ->create(['name' => 'First Category']);

    $two = Category::factory()
        ->create(['name' => 'Second Category']);

    livewire(Index::class, ['quantity' => 1])
        ->assertSee($one->name)
        ->assertDontSee($two->name)
        ->set('quantity', 2)
        ->assertSee($two->name);
});

it('can sort', function () {
    $one = Category::factory()
        ->create(['name' => 'A']);

    $two = Category::factory()
        ->create(['name' => 'B']);

    livewire(Index::class, ['sort' => 'name', 'direction' => 'asc'])
        ->assertSeeInOrder([$one->name, $two->name])
        ->set('direction', 'desc')
        ->assertSeeInOrder([$two->name, $one->name]);
});

it('can load method', function (array $data) {
    $method    = $data['method'];
    $component = $data['event']['class'];
    $event     = $data['event']['name'];

    $category = Category::factory()->create();

    livewire(Index::class)
        ->call($method, $category)
        ->assertEmittedTo($component, $event, $category);
})->with([
    fn () => [
        'method' => 'update',
        'event'  => [
            'class' => Update::class,
            'name'  => 'category::update::load',
        ],
    ],
    fn () => [
        'method' => 'delete',
        'event'  => [
            'class' => Delete::class,
            'name'  => 'category::delete::load',
        ],
    ],
]);
