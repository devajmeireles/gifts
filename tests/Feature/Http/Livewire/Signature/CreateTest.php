<?php

use App\Enums\DeliveryType;
use App\Http\Livewire\Signature\Create;
use App\Models\Item;

use App\Notifications\SignatureCreated;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseEmpty, assertDatabaseHas};
use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can create one', function () {
    Notification::fake();

    $name        = 'John Doe';
    $phone       = '123456789';
    $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

    $item = Item::factory()->create();

    livewire(Create::class)
        ->set('signature.name', $name)
        ->set('signature.phone', $phone)
        ->set('delivery', $remote = DeliveryType::Remotely->value)
        ->set('selected', $item->id)
        ->set('signature.observation', $observation)
        ->call('create')
        ->assertHasNoErrors();

    assertDatabaseHas('signatures', [
        'name'        => $name,
        'phone'       => $phone,
        'item_id'     => $item->id,
        'delivery'    => $remote,
        'observation' => $observation,
    ]);

    Notification::assertCount(1);
    Notification::assertSentTo(user(), SignatureCreated::class);
});

it('can create multiples', function () {
    Notification::fake();

    $name        = 'John Doe';
    $phone       = '123456789';
    $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

    $item = Item::factory()->create(['quantity' => 5]);

    livewire(Create::class)
        ->set('signature.name', $name)
        ->set('signature.phone', $phone)
        ->set('delivery', $remote = DeliveryType::Remotely->value)
        ->set('selected', $item->id)
        ->set('quantity', 5)
        ->set('signature.observation', $observation)
        ->call('create')
        ->assertHasNoErrors();

    assertDatabaseCount('signatures', 5);

    Notification::assertCount(1);
    Notification::assertSentTo(user(), SignatureCreated::class);
});

it('can create with quotas', function () {
    Notification::fake();

    $name        = 'John Doe';
    $phone       = '123456789';
    $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

    $item = Item::factory()
        ->quotable(5)
        ->create();

    livewire(Create::class)
        ->set('signature.name', $name)
        ->set('signature.phone', $phone)
        ->set('delivery', $remote = DeliveryType::Remotely->value)
        ->set('selected', $item->id)
        ->set('quantity', 5)
        ->set('signature.observation', $observation)
        ->call('create')
        ->assertHasNoErrors();

    assertDatabaseCount('signatures', 5);

    expect($item->refresh()->last_signed_at)
        ->not()->toBeNull();

    Notification::assertCount(1);
    Notification::assertSentTo(user(), SignatureCreated::class);
});

it('cannot create out of quantity', function () {
    Notification::fake();

    $name        = 'John Doe';
    $phone       = '123456789';
    $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

    $item = Item::factory()->create(['quantity' => 2]);

    livewire(Create::class)
        ->set('signature.name', $name)
        ->set('signature.phone', $phone)
        ->set('delivery', DeliveryType::Remotely->value)
        ->set('selected', $item->id)
        ->set('quantity', 3)
        ->set('signature.observation', $observation)
        ->call('create')
        ->assertDispatchedBrowserEvent('wireui:notification');

    assertDatabaseEmpty('signatures');

    Notification::assertNothingSentTo(user());
});
