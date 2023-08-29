<?php

use App\Enums\UserRole;
use App\Http\Livewire\Presence\{Create, Delete, Index, Update};
use App\Models\Presence;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can render component', function () {
    get(route('admin.presences.index'))
        ->assertSeeLivewire(Index::class);
});

it('can list', function () {
    $presence = Presence::factory()->create();

    livewire(Index::class)
        ->assertSee($presence->name)
        ->assertSee($presence->phone);
});

it('can search', function () {
    $presences = Presence::factory(2)->create();

    $first  = $presences->first();
    $second = $presences->last();

    livewire(Index::class)
        ->set('search', $first->name)
        ->assertSee($first->name)
        ->assertSee($first->phone)
        ->assertDontSee($second->name)
        ->assertDontSee($second->phone);
});

it('can paginate', function () {
    $presences = Presence::factory(2)->create();

    $first  = $presences->first();
    $second = $presences->last();

    livewire(Index::class, ['quantity' => 1])
        ->assertSee($first->name)
        ->assertSee($first->phone)
        ->assertDontSee($second->name)
        ->assertDontSee($second->phone);

    livewire(Index::class, ['quantity' => 1, 'page' => 2])
        ->assertSee($second->name)
        ->assertSee($second->phone)
        ->assertDontSee($first->name)
        ->assertDontSee($first->phone);
});

it('can change quantity', function () {
    $one = Presence::factory()
        ->create(['name' => 'First Presence']);

    $two = Presence::factory()
        ->create(['name' => 'Second Presence']);

    livewire(Index::class, ['quantity' => 1])
        ->assertSee($one->name)
        ->assertDontSee($two->name)
        ->set('quantity', 2)
        ->assertSee($two->name);
});

it('can sort', function () {
    $one = Presence::factory()
        ->create(['name' => 'A']);

    $two = Presence::factory()
        ->create(['name' => 'B']);

    livewire(Index::class, ['sort' => 'name', 'direction' => 'asc'])
        ->assertSeeInOrder([$one->name, $two->name])
        ->set('direction', 'desc')
        ->assertSeeInOrder([$two->name, $one->name]);
});

it('cannot see buttons if is guest', function () {
    $user = user();
    $user->update(['role' => UserRole::Guest]);

    get(route('admin.presences.index'))
        ->assertSeeLivewire(Index::class)
        ->assertDontSeeLivewire(Create::class)
        ->assertDontSeeLivewire(Update::class)
        ->assertDontSeeLivewire(Delete::class);
});

it('can filter for empty results', function () {
    Presence::factory()
        ->create(['name' => 'First Presence']);

    livewire(Index::class)
        ->set('search', 'Second Presence')
        ->assertSee('Nenhum registro encontrado.')
        ->assertSee('Quantidade');
});
