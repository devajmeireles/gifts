<?php

use App\Enums\UserRole;
use App\Http\Livewire\Signature\{Create, Delete, Index, Update};
use App\Models\{Category, Item, Signature};

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can render component', function () {
    get(route('admin.signatures.index'))
        ->assertSeeLivewire(Index::class);
});

it('can list', function () {
    $signature = Signature::factory()
        ->forItem()
        ->create();

    livewire(Index::class)
        ->assertSee($signature->name)
        ->assertSee($signature->item->name);
});

it('can search', function () {
    $signatures = Signature::factory(10)
        ->forItem()
        ->create();

    $first = $signatures->first();
    $last  = $signatures->last();

    livewire(Index::class)
        ->set('search', $first->name)
        ->assertSee($first->name)
        ->assertDontSee($last->phone);
});

it('can paginate', function () {
    $signature = Signature::factory(24)
        ->forItem()
        ->create();

    $first = $signature->first();
    $last  = $signature->last();

    $first->update(['name' => fake()->name()]);
    $last->update(['name' => fake()->name()]);

    livewire(Index::class)
        ->assertSee($first->name)
        ->assertDontSee($last->name);

    livewire(Index::class, ['page' => 2])
        ->assertDontSee($first->name)
        ->assertSee($last->name);
});

it('can filter by item', function () {
    $item = Item::factory()
        ->activated()
        ->create();

    $signatures = Signature::factory(10)
        ->forItem()
        ->create();

    $first = $signatures->first();
    $last  = $signatures->last();

    $last->item_id = $item->id;
    $last->save();

    livewire(Index::class)
        ->call('filter', [
            'item' => $item->id,
        ])
        ->assertDontSee($first->name)
        ->assertSee($last->name);
});

it('can filter by category', function () {
    $category = Category::factory()
        ->activated()
        ->create();

    $item = Item::factory()
        ->activated()
        ->for($category)
        ->create();

    $signatures = Signature::factory(10)
        ->forItem()
        ->create();

    $first = $signatures->first();
    $last  = $signatures->last();

    $last->item_id = $item->id;
    $last->save();

    livewire(Index::class)
        ->call('filter', [
            'category' => $category->id,
        ])
        ->assertDontSee($first->name)
        ->assertSee($last->name);
});

it('can filter by date', function () {
    $signatures = Signature::factory(10)
        ->forItem()
        ->create();

    $first = $signatures->first();
    $last  = $signatures->last();

    $last->created_at = now()->subDays(5);
    $last->save();

    livewire(Index::class)
        ->call('filter', [
            'start' => now()->subDays(10)->format('Y-m-d'),
            'end'   => now()->subDays()->format('Y-m-d'),
        ])
        ->assertDontSee($first->name)
        ->assertSee($last->name);
});

it('cannot see buttons if is guest', function () {
    Signature::factory()
        ->forItem()
        ->create();

    $user = user();
    $user->update(['role' => UserRole::Guest]);

    get(route('admin.signatures.index'))
        ->assertSeeLivewire(Index::class)
        ->assertDontSeeLivewire(Create::class)
        ->assertDontSeeLivewire(Update::class)
        ->assertDontSeeLivewire(Delete::class);
});

it('can filter for empty results', function () {
    Signature::factory()
        ->forItem()
        ->create(['name' => 'First Signature']);

    livewire(Index::class)
        ->set('search', 'Second Signature')
        ->assertSee('Nenhuma assinatura encontrada')
        ->assertSee('Pesquise alguma coisa...');
});
