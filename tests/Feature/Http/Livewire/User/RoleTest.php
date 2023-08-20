<?php

use App\Enums\UserRole;
use App\Http\Livewire\User\Role;
use App\Models\User;

use function Pest\Livewire\livewire;

it('can change role', function (UserRole $from, UserRole $to) {
    $user = User::factory()
        ->role($from)
        ->create();

    livewire(Role::class, ['user' => $user])
        ->set('role', $to->value)
        ->assertHasNoErrors()
        ->assertDispatchedBrowserEvent('wireui:notification');

    expect($user->fresh()->role)->toBe($to);
})->with([
    [UserRole::User, UserRole::Guest],
    [UserRole::Admin, UserRole::User],
]);
