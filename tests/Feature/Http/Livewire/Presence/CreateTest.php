<?php

use App\Livewire\Presence\Create;

use Faker\Provider\Lorem;

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseEmpty, assertDatabaseHas};
use function Pest\Livewire\livewire;

it('can create', function () {
    livewire(Create::class)
        ->set('presence.name', $name = fake()->name())
        ->set('presence.phone', $phone = fake()->phoneNumber())
        ->set('presence.observation', $observation = fake()->sentence())
        ->call('create');

    assertDatabaseHas('presences', [
        'name'         => $name,
        'phone'        => $phone,
        'observation'  => $observation,
        'is_confirmed' => true,
    ]);

    assertDatabaseCount('presences', 1);
});

it('can validate', function () {
    livewire(Create::class)
        ->set('presence.name', '')
        ->set('presence.phone', Lorem::text())
        ->call('create')
        ->assertHasErrors([
            'presence.name'  => 'required',
            'presence.phone' => 'max',
        ])
        ->assertNotDispatched('presence::index::refresh');

    assertDatabaseEmpty('presences');
});

it('cannot create with description enable but empty', function () {
    livewire(Create::class)
        ->set('observation', true)
        ->set('presence.name', '')
        ->set('presence.phone', Lorem::text())
        ->set('presence.observation', '')
        ->call('create')
        ->assertHasErrors([
            'presence.name'        => 'required',
            'presence.phone'       => 'max',
            'presence.observation' => 'required',
        ])
        ->assertNotDispatched('presence::index::refresh');

    assertDatabaseEmpty('presences');
});
