<?php

use GrantHolle\Timezone\Tests\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    test()->user = seedUser(['timezone' => null]);
});

it('can detect timezone on login with default ip address location', function () {
    expect($this->user->timezone)->toBeNull();

    $this->post('/login', ['id' => $this->user->id]);

    $this->user->refresh();
    expect($this->user->timezone)->toBeString();
});
