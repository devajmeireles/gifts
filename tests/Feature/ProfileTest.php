<?php

test('profile page is displayed', function () {
    $user = createTestUser();

    $response = $this
        ->actingAs($user)
        ->get('/profile');

    $response->assertOk();
});

test('can update profile', function () {
    $user = createTestUser();

    $response = $this->patch(route('profile.edit'), [
        'name'     => 'Test User',
        'username' => 'testuser',
    ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('profile.edit'));

    $user->refresh();

    expect($user->name)
        ->toBe('Test User')
        ->and($user->username)
        ->toBe('testuser');
});
