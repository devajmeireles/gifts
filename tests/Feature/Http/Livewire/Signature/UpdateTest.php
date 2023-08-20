<?php

use App\Enums\DeliveryType;
use App\Http\Livewire\Signature\Update;
use App\Models\{Item, Signature};

use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can update', function () {
    $signature = Signature::factory()
        ->forItem()
        ->create();

    livewire(Update::class, ['signature' => $signature])
        ->set('signature.name', $name = 'Foo Bar')
        ->set('signature.phone', $phone = '123456789')
        ->set('delivery', DeliveryType::Remote->value)
        ->set('selected', $signature->item_id)
        ->set('signature.observation', $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
        ->call('update')
        ->assertHasNoErrors();

    expect($signature->refresh())
        ->name->toBe($name)
        ->phone->toBe($phone)
        ->delivery->toBe(DeliveryType::Remote)
        ->observation->toBe($observation);
});

it('can update and change item', function () {
    $item = Item::factory()
        ->activated()
        ->create();

    $signature = Signature::factory()
        ->forItem()
        ->create();

    livewire(Update::class, ['signature' => $signature])
        ->set('signature.name', $name = 'Foo Bar')
        ->set('signature.phone', $phone = '123456789')
        ->set('delivery', DeliveryType::Remote->value)
        ->set('selected', $item->id)
        ->set('signature.observation', $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
        ->call('update')
        ->assertHasNoErrors();

    $signature->refresh();

    expect($signature->item_id)
        ->toBe($item->id)
        ->and($signature->item)
        ->toBeInstanceOf(Item::class);
});

it('cannot update using unavailable item', function () {
    $item = Item::factory()
        ->quotable(5)
        ->create();

    Signature::factory(5)
        ->for($item)
        ->create();

    $signature = Signature::factory()
        ->forItem()
        ->delivery(DeliveryType::Locally)
        ->create();

    livewire(Update::class, ['signature' => $signature])
        ->set('signature.name', 'Foo Bar')
        ->set('signature.phone', '123456789')
        ->set('delivery', DeliveryType::Remote->value)
        ->set('selected', $item->id)
        ->set('signature.observation', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
        ->call('update')
        ->assertDispatchedBrowserEvent('wireui:notification');

    expect($signature->refresh())
        ->name->not->toBe('Foo Bar')
        ->phone->not->toBe('123456789')
        ->delivery->not->toBe(DeliveryType::Remote)
        ->observation->not->toBe('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
});

it('can update to new item disabling to be reused', function () {
    $item = Item::factory()
        ->activated()
        ->create(['quantity' => 1]);

    $signature = Signature::factory()
        ->forItem()
        ->create();

    livewire(Update::class, ['signature' => $signature])
        ->set('signature.name', 'Foo Bar')
        ->set('signature.phone', '123456789')
        ->set('delivery', DeliveryType::Remote->value)
        ->set('selected', $item->id)
        ->set('signature.observation', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
        ->call('update')
        ->assertHasNoErrors();

    $signature->refresh();
    $item->refresh();

    expect($signature->item_id)
        ->toBe($item->id)
        ->and($item->is_active)
        ->toBeFalse();
});
