<?php

use App\Providers\RouteServiceProvider;

it('can see login page', function () {
    $response = $this->get(route('admin.login'));

    $response->assertStatus(200);
});

it('can authenticate', function () {
    $user = createTestUser(login: false);

    $response = $this->post(route('admin.login'), [
        'username' => $user->username,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('admin.dashboard'));
});

it('cannot authenticate using wrong password', function () {
    $user = createTestUser(login: false);

    $this->post(route('admin.login'), [
        'username' => $user->username,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});
