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
        ->assertSee('1 item nesta categoria');
});

it('can view category with multiples item', function () {
    $category = Category::factory()
        ->activated()
        ->create();

    Item::factory(5)
        ->for($category)
        ->create();

    livewire(Index::class)
        ->call('category')
        ->assertSee('5 itens nesta categoria');
});

it('can view in correct order')->todo();
