<?php

use App\Http\Livewire\Signature\Index;
use App\Models\{Item, Signature};

use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can render component', function () {
    $this->get(route('admin.signatures'))
        ->assertSeeLivewire(Index::class);
});

it('can list', function () {
    $signature = Signature::factory()
        ->forItem()
        ->create();

    livewire(Index::class)
        ->assertSee($signature->name)
        ->assertSee($signature->phone);
});

it('can paginate', function () {
    $signature = Signature::factory(24)
        ->forItem()
        ->create();

    $first = $signature->first();
    $last  = $signature->last();

    livewire(Index::class)
        ->assertSee($first->name)
        ->assertDontSee($last->name);

    livewire(Index::class, ['page' => 2])
        ->assertDontSee($first->name)
        ->assertSee($last->name);
});
