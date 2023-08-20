<?php

use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\from;

it('can update', function () {
    $user = createTestUser();

    from(route('admin.password.edit'))
        ->patchJson(route('admin.password.update'), [
            'current_password'      => 'password',
            'password'              => 'Senh4!@#Abc',
            'password_confirmation' => 'Senh4!@#Abc',
        ])
        ->assertStatus(302)
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.password.edit'));

    expect(Hash::check('Senh4!@#Abc', $user->refresh()->password))
        ->toBeTrue();
});

it('cannot update password using wrong password', function () {
    $user = createTestUser();

    from(route('admin.password.edit'))
        ->patchJson(route('admin.password.update'), [
            'current_password'      => 'wrong-password',
            'password'              => 'Senh4!@#Abc',
            'password_confirmation' => 'Senh4!@#Abc',
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['current_password']);

    expect(Hash::check('Senh4!@#Abc', $user->refresh()->password))
        ->toBeFalse();
});
