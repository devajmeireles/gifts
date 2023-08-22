<?php

use function Pest\Laravel\{get, post};

it('can see login page', function () {
    get(route('admin.login'))
        ->assertSee('Acessar');
});

it('can authenticate', function () {
    $user = createTestUser(login: false);

    $response = post(route('admin.login'), [
        'username' => $user->username,
        'password' => 'password',
    ])->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticated();
});

it('cannot authenticate using wrong password', function () {
    $user = createTestUser(login: false);

    post(route('admin.login'), [
        'username' => $user->username,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});
