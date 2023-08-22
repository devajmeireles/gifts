<?php

use App\Http\Livewire\Frontend\Index;
use App\Models\{Category, Item};
use App\Services\Settings\Facades\Settings;

use Faker\Provider\Lorem;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

it('can view', function () {
    Settings::set('titulo', $title = Lorem::text(10));
    Settings::set('subtitulo', $subtitle = Lorem::text());

    get(route('frontend'))
        ->assertOk()
        ->assertSeeLivewire(Index::class)
        ->assertSee($title)
        ->assertSee($subtitle);
});

it('can view out of category warning', function () {
    livewire(Index::class)
        ->call('category')
        ->assertSee('Ainda não há nenhuma categoria de presente. Volte daqui a pouco!');
});

it('can view category', function () {
    $category = Category::factory()
        ->activated()
        ->create(['name' => 'Category']);

    livewire(Index::class)
        ->call('category')
        ->assertSee($category->name);
});

it('can view category with single item', function () {
    $category = Category::factory()
        ->activated()
        ->create();

    Item::factory()
        ->for($category)
        ->create();

    livewire(Index::class)
        ->call('category')
        ->assertSee('1 item');
});

it('can view category with multiples item', function (int $quantity) {
    $category = Category::factory()
        ->activated()
        ->create();

    Item::factory($quantity)
        ->for($category)
        ->create();

    livewire(Index::class)
        ->call('category')
        ->assertSee("$quantity itens");
})->with([5, 10, 15, 20, 30, 50, 100]);

it('can view item', function () {
    $items = Item::factory(2)
        ->for($category = Category::factory()->activated()->create())
        ->activated()
        ->create();

    $first = $items->first();
    $last  = $items->last();

    livewire(Index::class)
        ->call('item', $category)
        ->assertSee([
            $first->name,
            $last->name,
        ]);
});

it('can back to the initial view', function () {
    $items = Item::factory(2)
        ->for($category = Category::factory()->activated()->create())
        ->activated()
        ->create();

    $first = $items->first();
    $last  = $items->last();

    livewire(Index::class)
        ->call('item', $category)
        ->assertSee([
            $first->name,
            $last->name,
        ])
        ->call('more')
        ->assertEmitted('frontend::load::more')
        ->assertSet('limit', 18)
        ->call('category')
        ->assertSet('filtered', false)
        ->assertSet('limit', 9)
        ->assertSet('search', null);
});

it('can view description', function () {
    $items = Item::factory(2)
        ->for($category = Category::factory()->activated()->create())
        ->activated()
        ->create();

    $first = $items->first();
    $last  = $items->last();

    $first->update(['description' => Lorem::text()]);
    $last->update(['description' => null]);

    livewire(Index::class)
        ->call('item', $category)
        ->assertSee($first->description)
        ->assertDontSee($last->description);
});

it('cal load more', function () {
    $items = Item::factory(2)
        ->for($category = Category::factory()->activated()->create())
        ->activated()
        ->create();

    $first = $items->first();
    $last  = $items->last();

    $first->update(['name' => 'Abcdef']);
    $last->update(['name' => 'Bcdefg']);

    livewire(Index::class)
        ->set('limit', 1)
        ->call('item', $category)
        ->assertSee($first->name)
        ->call('more')
        ->assertEmitted('frontend::load::more')
        ->call('item', $category)
        ->assertSee($last->name);
});

it('can view in correct order', function () {
    $items = Item::factory(2)
        ->for($category = Category::factory()->activated()->create())
        ->activated()
        ->create();

    $first = $items->first();
    $last  = $items->last();

    $first->update(['name' => 'Abcdef']);
    $last->update(['name' => 'Bcdefg']);

    livewire(Index::class)
        ->call('item', $category)
        ->assertSeeInOrder([
            $first->name,
            $last->name,
        ]);
});
