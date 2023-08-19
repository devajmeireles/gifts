<?php

use function Pest\Laravel\get;

test('profile page is displayed', function () {
    createTestUser();

    get(route('admin.profile.edit'))
        ->assertOk();
});

test('can update profile', function () {
    $user = createTestUser();

    $response = $this->patch(route('admin.profile.edit'), [
        'name'     => 'Test User',
        'username' => 'testuser',
    ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.profile.edit'));

    $user->refresh();

    expect($user->name)
        ->toBe('Test User')
        ->and($user->username)
        ->toBe('testuser');
});
