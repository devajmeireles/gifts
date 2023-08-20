<?php

use App\Enums\UserRole;
use App\Http\Livewire\Impersonate\Login;

use function Pest\Laravel\{assertAuthenticatedAs, get};
use function Pest\Livewire\livewire;

it('can login', function () {
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
});

it('cannot self login', function () {
    $admin = createTestUser();

    livewire(Login::class, ['user' => $admin])
        ->call('login')
        ->assertDispatchedBrowserEvent('wireui:notification')
        ->assertSessionMissing('impersonate');

    assertAuthenticatedAs($admin);

    get(route('admin.dashboard'))
        ->assertSee($admin->name);
});

it('cannot login when logged is not admin', function () {
    $one = createTestUser(role: UserRole::User);
    $two = createTestUser(role: UserRole::User, login: false);

    livewire(Login::class, ['user' => $two])
        ->call('login')
        ->assertDispatchedBrowserEvent('wireui:notification');

    assertAuthenticatedAs($one);

    get(route('admin.dashboard'))
        ->assertSee($one->name);
});

it('cannot re login', function () {
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

    livewire(Login::class, ['user' => $admin])
        ->call('login')
        ->assertDispatchedBrowserEvent('wireui:notification');

    assertAuthenticatedAs($user);
});
