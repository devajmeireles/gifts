<?php

use App\Enums\Dashboard\CardType;
use App\Http\Livewire\Dashboard\Card;
use App\Models\{Item, Signature};

use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can view all items', function () {
    Item::factory(100)
        ->activated()
        ->create();

    livewire(Card::class, ['type' => CardType::AllItems])
        ->call('load')
        ->assertSee('100');
});

it('can view signed items', function () {
    $items = Item::factory(150)
        ->activated()
        ->create();

    $items->each(function (Item $item) {
        Signature::factory()
            ->for($item)
            ->create();
    });

    livewire(Card::class, ['type' => CardType::AllSignedItems])
        ->call('load')
        ->assertSee('150');
});

it('can view unsigned items', function () {
    Item::factory(25)->create();

    $items = Item::factory(150)
        ->activated()
        ->create();

    $items->each(function (Item $item) {
        Signature::factory()
            ->for($item)
            ->create();
    });

    livewire(Card::class, ['type' => CardType::AllUnsignedItems])
        ->call('load')
        ->assertSee('25');
});
