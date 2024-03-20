<?php

beforeEach(function () {
    test()->user = seedUser(['timezone' => null]);
});

it('can detect timezone on login with default ip address location', function () {
    expect($this->user->timezone)->toBeNull();

    $this->post('/login', ['id' => $this->user->id]);

    $this->user->refresh();
    expect($this->user->timezone)->toBeString();
});

it('can opt out of detection', function () {
    config()->set('timezone.events', false);
    expect($this->user->timezone)->toBeNull();

    $this->post('/login', ['id' => $this->user->id]);

    $this->user->refresh();
    expect($this->user->timezone)->toBeNull();
});

it("won't overwrite existing values", function () {
    config()->set('timezone.overwrite', false);
    $timezone = fake()->timezone();
    $this->user->update(['timezone' => $timezone]);

    $this->user->refresh();
    expect($this->user->timezone)->toEqual($timezone);

    $this->post('/login', ['id' => $this->user->id]);

    $this->user->refresh();
    expect($this->user->timezone)->toEqual($timezone);
});

it('can overwrite existing values', function () {
    config()->set('timezone.overwrite', true);
    $timezone = 'Asia/Shanghai';
    $this->user->update(['timezone' => $timezone]);

    $this->user->refresh();
    expect($this->user->timezone)->toEqual($timezone);

    $this->post('/login', ['id' => $this->user->id]);

    $this->user->refresh();
    expect($this->user->timezone)->not()->toEqual($timezone);
});
