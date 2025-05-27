<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class)->in('Feature');

function createTestUser(
    array    $attributes = [],
    UserRole $role = UserRole::Admin,
    bool     $login = true
): User {
    $user = User::factory()
        ->role($role)
        ->create($attributes);

    if ($login) {
        test()->actingAs($user);
    }

    return $user;
}
