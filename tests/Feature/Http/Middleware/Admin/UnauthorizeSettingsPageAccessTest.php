<?php

use App\Enums\UserRole;

use App\Models\User;

use function Pest\Laravel\{actingAs, get};

it('can access', function (User $user) {
    actingAs($user)
        ->get(route('admin.settings'))
        ->assertOk();
})->with([
    fn () => createTestUser(login: false),
    fn () => createTestUser(role: UserRole::User, login: false),
]);

it('cannot access if is guest', function () {
    createTestUser(role: UserRole::Guest);

    get(route('admin.settings'))
        ->assertForbidden();
});
