<?php

use App\Enums\UserRole;
use App\Http\Livewire\User\Index;

use function Pest\Laravel\get;

it('can access', function () {
    createTestUser();

    get(route('admin.users'))
        ->assertOk()
        ->assertSeeLivewire(Index::class);
});

it('cannot access', function (UserRole $role) {
    createTestUser(role: $role);

    get(route('admin.users'))
        ->assertForbidden();
})->with([
    [UserRole::User],
    [UserRole::Guest],
]);
