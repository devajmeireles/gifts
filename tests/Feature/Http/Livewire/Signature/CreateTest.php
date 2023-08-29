<?php

use App\Enums\DeliveryType;
use App\Http\Livewire\Signature\Create;
use App\Models\Item;

use App\Notifications\SignatureCreated;
use App\Services\Settings\Facades\Settings;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseEmpty, assertDatabaseHas};
use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can create one', function () {
    Notification::fake();

    $name        = 'John Doe';
    $phone       = '123456789';
    $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

    $item = Item::factory()
        ->activated()
        ->create();

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
    Notification::assertSentTo($item, SignatureCreated::class);
});

it('can create multiples', function () {
    Notification::fake();

    $name        = 'John Doe';
    $phone       = '123456789';
    $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

    $item = Item::factory()
        ->activated()
        ->create(['quantity' => 5]);

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
    Notification::assertSentTo($item, SignatureCreated::class);
});

it('can create with quotas', function () {
    Notification::fake();

    $name        = 'John Doe';
    $phone       = '123456789';
    $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

    $item = Item::factory()
        ->activated()
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
    Notification::assertSentTo($item, SignatureCreated::class);
});

it('cannot create out of quantity', function () {
    Notification::fake();

    $name        = 'John Doe';
    $phone       = '123456789';
    $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

    $item = Item::factory()
        ->activated()
        ->create(['quantity' => 2]);

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

    Notification::assertNothingSentTo($item);
});

it('cannot create with inactivated item', function () {
    Notification::fake();

    $name        = 'John Doe';
    $phone       = '123456789';
    $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

    $item = Item::factory()
        ->inactivated()
        ->create(['quantity' => 5]);

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

    Notification::assertNothingSentTo($item);
});

it('can create one signature and presence', function () {
    Notification::fake();

    Settings::shouldReceive('get')
        ->with('converter_assinaturas_em_presenca')
        ->once()
        ->andReturnTrue();

    $item = Item::factory()
        ->activated()
        ->create();

    assertDatabaseEmpty('presences');

    livewire(Create::class)
        ->set('signature.name', $name = 'John Doe')
        ->set('signature.phone', $phone = '123456789')
        ->set('delivery', $remote = DeliveryType::InPerson->value)
        ->set('selected', $item->id)
        ->call('create')
        ->assertHasNoErrors();

    assertDatabaseHas('signatures', [
        'name'     => $name,
        'phone'    => $phone,
        'item_id'  => $item->id,
        'delivery' => $remote,
    ]);

    assertDatabaseHas('presences', [
        'name'  => $name,
        'phone' => $phone,
    ]);
});

it('can create multiples signature and only one presence', function () {
    Notification::fake();

    Settings::shouldReceive('get')
        ->with('converter_assinaturas_em_presenca')
        ->once()
        ->andReturnTrue();

    $item = Item::factory()
        ->quotable(5)
        ->create();

    assertDatabaseEmpty('presences');

    livewire(Create::class)
        ->set('signature.name', $name = 'John Doe')
        ->set('signature.phone', $phone = '123456789')
        ->set('delivery', DeliveryType::InPerson->value)
        ->set('quantity', $quantity = ($item->quantity - 1))
        ->set('selected', $item->id)
        ->call('create')
        ->assertHasNoErrors();

    assertDatabaseCount('signatures', $quantity);

    assertDatabaseHas('presences', [
        'name'  => $name,
        'phone' => $phone,
    ]);

    assertDatabaseCount('presences', 1);
});

it('cannot create signatures and presence if delivery type is not in person', function () {
    Notification::fake();

    Settings::shouldReceive('get')
        ->with('converter_assinaturas_em_presenca')
        ->once()
        ->andReturnTrue();

    $item = Item::factory()
        ->activated()
        ->create();

    livewire(Create::class)
        ->set('signature.name', $name = 'John Doe')
        ->set('signature.phone', $phone = '123456789')
        ->set('delivery', $remote = DeliveryType::Remotely->value)
        ->set('selected', $item->id)
        ->call('create')
        ->assertHasNoErrors();

    assertDatabaseHas('signatures', [
        'name'     => $name,
        'phone'    => $phone,
        'item_id'  => $item->id,
        'delivery' => $remote,
    ]);

    assertDatabaseEmpty('presences');
});
