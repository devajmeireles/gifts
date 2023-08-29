<?php

use App\Http\Livewire\Presence\Update;
use App\Models\Presence;

use Faker\Provider\Lorem;

use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can update', function () {
    $presence = Presence::factory()->create();

    livewire(Update::class)
        ->call('load', $presence)
        ->set('presence.name', $name = fake()->name())
        ->set('presence.phone', $phone = fake()->phoneNumber())
        ->set('presence.observation', $observation = fake()->sentence())
        ->call('update')
        ->assertHasNoErrors()
        ->assertSuccessful()
        ->assertEmittedUp('presence::index::refresh');

    $presence->refresh();

    expect($presence->name)
        ->toBe($name)
        ->and($presence->phone)
        ->toBe($phone)
        ->and($presence->observation)
        ->toBe($observation);
});

it('can validate', function () {
    $saved = $presence = Presence::factory()
        ->create([
            'observation' => Lorem::text(),
        ]);

    $text = Lorem::text(500) .
        Lorem::text(500) .
        Lorem::text(500) .
        Lorem::text(500);

    livewire(Update::class)
        ->call('load', $presence)
        ->set('observation', true)
        ->set('presence.name', '')
        ->set('presence.phone', $text)
        ->set('presence.observation', $text)
        ->call('update')
        ->assertHasErrors([
            'presence.name'        => 'required',
            'presence.phone'       => 'max',
            'presence.observation' => 'max',
        ])
        ->assertNotEmitted('presence::index::refresh');

    $presence->refresh();

    expect($presence->name)
        ->toBe($saved->name)
        ->and($presence->phone)
        ->toBe($saved->phone)
        ->and($presence->observation)
        ->toBe($saved->observation);
});
