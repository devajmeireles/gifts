<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class)->in('Feature');

function createTestUser(array $attributes = [], bool $login = true): User
{
    $user = User::factory()->create($attributes);

    if ($login) {
        test()->actingAs($user);
    }

    return $user;
}
