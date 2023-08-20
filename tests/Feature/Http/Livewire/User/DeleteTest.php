<?php

use App\Http\Livewire\User\Delete;
use App\Models\User;

use function Pest\Laravel\{assertModelExists, assertModelMissing};
use function Pest\Livewire\livewire;

beforeEach(fn () => createTestUser());

it('can delete', function () {
    $user = User::factory()
        ->user()
        ->create();

    livewire(Delete::class, ['user' => $user])
        ->call('delete')
        ->assertHasNoErrors()
        ->assertEmittedUp('user::index::refresh');

    assertModelMissing($user);
});

it('cannot delete self', function () {
    $user = user();

    livewire(Delete::class, ['user' => $user])
        ->call('delete')
        ->assertDispatchedBrowserEvent('wireui:notification');

    assertModelExists($user);
});
