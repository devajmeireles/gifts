<?php

use App\Enums\UserRole;
use App\Http\Livewire\Impersonate\{Login, Logout};

use function Pest\Laravel\{assertAuthenticatedAs, get};
use function Pest\Livewire\livewire;

it('can logout', function () {
    $admin = createTestUser();
    $user  = createTestUser(role: UserRole::User, login: false);

    livewire(Login::class, ['user' => $user])
        ->call('login')
        ->assertRedirect(route('admin.dashboard'))
        ->assertSessionHas('impersonate', [
            'from' => $admin->id,
            'to'   => $user->id,
        ]);

    assertAuthenticatedAs($user);

    get(route('admin.dashboard'))
        ->assertSee($user->name)
        ->assertDontSee($admin->name);

    livewire(Logout::class)
        ->call('logout')
        ->assertRedirect(route('admin.dashboard'));

    get(route('admin.dashboard'))
        ->assertSee($admin->name)
        ->assertDontSee($user->name);
});

it('cannot logout without session', function () {
    $user = createTestUser(role: UserRole::User);

    livewire(Logout::class)
        ->call('logout')
        ->assertDispatchedBrowserEvent('wireui:notification');

    assertAuthenticatedAs($user);
});
