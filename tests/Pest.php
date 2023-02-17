<?php

use GrantHolle\Timezone\Tests\TestCase;
use GrantHolle\Timezone\Tests\Models\User;

uses(TestCase::class)->in(__DIR__);

function seedUser(array $attributes = []): User {
    return User::create([
        'name' => fake()->name(),
        'email' => fake()->email(),
        'password' => bcrypt('secret'),
        'timezone' => fake()->timezone(),
        ...$attributes,
    ]);
}

function logIn(array $attributes = []): User {
    test()->user = seedUser($attributes);
    test()->be(test()->user);

    return test()->user;
}
