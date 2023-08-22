<?php

use App\Enums\DeliveryType;
use App\Http\Livewire\Frontend\Signature;
use App\Models\Item;

use App\Notifications\SignatureCreated;
use Database\Seeders\SettingSeeder;

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseEmpty, assertDatabaseHas};
use function Pest\Livewire\livewire;

beforeEach(fn () => $this->seed(SettingSeeder::class));

it('can create one', function () {
    Notification::fake();

    $name        = 'John Doe';
    $phone       = '123456789';
    $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

    $item = Item::factory()
        ->activated()
        ->create();

    livewire(Signature::class)
        ->set('signature.name', $name)
        ->set('signature.phone', $phone)
        ->set('delivery', $remote = DeliveryType::Remotely->value)
        ->set('item', $item)
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

    livewire(Signature::class)
        ->set('signature.name', $name)
        ->set('signature.phone', $phone)
        ->set('delivery', DeliveryType::Remotely->value)
        ->set('item', $item)
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

    livewire(Signature::class)
        ->set('signature.name', $name)
        ->set('signature.phone', $phone)
        ->set('delivery', $remote = DeliveryType::Remotely->value)
        ->set('item', $item)
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

it('can view item reference', function () {
    $item = Item::factory()
        ->activated()
        ->quotable(1)
        ->create(['reference' => $url = fake()->url()]);

    livewire(Signature::class)
        ->set('item', $item)
        ->set('modal', true)
        ->assertSee($url)
        ->assertSee('Veja um modelo do item desejado clicando aqui.');
});

it('cannot create out of quantity', function () {
    Notification::fake();

    $name        = 'John Doe';
    $phone       = '123456789';
    $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

    $item = Item::factory()
        ->activated()
        ->create(['quantity' => 2]);

    livewire(Signature::class)
        ->set('signature.name', $name)
        ->set('signature.phone', $phone)
        ->set('delivery', DeliveryType::Remotely->value)
        ->set('item', $item)
        ->set('quantity', 3)
        ->set('signature.observation', $observation)
        ->call('create')
        ->assertDispatchedBrowserEvent('wireui:dialog');

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

    livewire(Signature::class)
        ->set('signature.name', $name)
        ->set('signature.phone', $phone)
        ->set('delivery', DeliveryType::Remotely->value)
        ->set('item', $item)
        ->set('quantity', 3)
        ->set('signature.observation', $observation)
        ->call('create')
        ->assertDispatchedBrowserEvent('wireui:dialog');

    assertDatabaseEmpty('signatures');

    Notification::assertNothingSentTo($item);
});
