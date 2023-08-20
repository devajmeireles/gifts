<?php

use App\Enums\UserRole;
use App\Models\User;

use function Pest\Laravel\{actingAs, get};

it('can access', function () {
    createTestUser();

    get(route('admin.users'))
        ->assertOk();
});

it('cannot access', function (User $user) {
    actingAs($user)
        ->get(route('admin.users'))
        ->assertForbidden();
})->with([
    fn () => createTestUser(role: UserRole::User, login: false),
    fn () => createTestUser(role: UserRole::Guest, login: false),
]);
