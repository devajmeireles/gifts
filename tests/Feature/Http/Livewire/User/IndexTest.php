<?php

use App\Http\Livewire\User\Index;
use App\Models\{Item, User};

use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can render component', function () {
    $this->get(route('admin.users'))
        ->assertSeeLivewire(Index::class);
});

it('can list', function () {
    $user = User::factory()
        ->user()
        ->create();

    livewire(Index::class)
        ->assertSee($user->name)
        ->assertSee($user->username);
});

it('cannot see self', function () {
    $user = User::factory()
        ->user()
        ->create();

    livewire(Index::class)
        ->assertSee($user->name)
        ->assertSee($user->username)
        ->assertDontSee(user()->username);
});

it('can search', function () {
    $user = User::factory(2)
        ->guest()
        ->create();

    $one = $user->first();
    $two = $user->last();

    livewire(Index::class)
        ->set('search', $one->username)
        ->assertSee($one->username)
        ->assertDontSee($two->username);

    livewire(Index::class)
        ->set('search', $two->username)
        ->assertSee($two->username)
        ->assertDontSee($one->username);
});

it('can paginate', function () {
    $user = User::factory(2)
        ->guest()
        ->create();

    $one = $user->first();
    $two = $user->last();

    livewire(Index::class, ['quantity' => 1])
        ->assertSee($one->username)
        ->assertDontSee($two->username);

    livewire(Index::class, ['quantity' => 1, 'page' => 2])
        ->assertSee($two->username)
        ->assertDontSee($one->username);
});

it('can change quantity', function () {
    $user = User::factory(2)
        ->user()
        ->create();

    $one = $user->first();
    $two = $user->last();

    livewire(Index::class, ['quantity' => 1])
        ->assertSee($one->name)
        ->assertDontSee($two->name)
        ->set('quantity', 2)
        ->assertSee($two->name);
});

it('can sort', function () {
    $user = User::factory(2)
        ->user()
        ->create();

    $one = $user->first();
    $two = $user->last();

    $one->update(['name' => 'A']);
    $two->update(['name' => 'B']);

    livewire(Index::class, ['sort' => 'name', 'direction' => 'asc'])
        ->assertSeeInOrder([$one->name, $two->name])
        ->set('direction', 'desc')
        ->assertSeeInOrder([$two->name, $one->name]);
});
