<?php

use App\Enums\UserRole;

use App\Http\Livewire\Setting\Index;

use function Pest\Laravel\get;

it('can access', function (UserRole $role) {
    createTestUser(role: $role);

    get(route('admin.settings'))
        ->assertOk()
        ->assertSeeLivewire(Index::class);
})->with([
    [UserRole::Admin],
    [UserRole::User],
]);

it('cannot access', function () {
    createTestUser(role: UserRole::Guest);

    get(route('admin.settings'))
        ->assertForbidden();
});
