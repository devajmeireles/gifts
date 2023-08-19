<?php

use Illuminate\Support\Facades\Hash;

it('can update password', function () {
    $user = createTestUser();

    $response = $this->from(route('admin.profile.edit'))
        ->put(route('admin.password.update'), [
            'current_password'      => 'password',
            'password'              => 'Senh4!@#Abc',
            'password_confirmation' => 'Senh4!@#Abc',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.profile.edit'));

    $this->assertTrue(Hash::check('Senh4!@#Abc', $user->refresh()->password));
});

it('cannot update password using wrong password', function () {
    $user = createTestUser();

    $response = $this->from(route('admin.profile.edit'))
        ->put(route('admin.password.update'), [
            'current_password'      => 'wrong-password',
            'password'              => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasErrorsIn('updatePassword', 'current_password')
        ->assertRedirect(route('admin.profile.edit'));
});
