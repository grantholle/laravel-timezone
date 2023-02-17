<?php

use Carbon\CarbonImmutable;
use GrantHolle\Timezone\Facades\Timezone;
use GrantHolle\Timezone\Tests\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can detect user timezone', function (User $user) {
    expect(timezone())->toEqual($user->timezone ?? config('app.timezone'));
})->with([
    'a user that has a timezone' => fn () => logIn(),
    'a user without a timezone' => fn () => logIn(['timezone' => null]),
]);

it('can convert date to local time object', function () {
    $user = logIn();
    $date = CarbonImmutable::create(2000, 4, 1, 15);
    $expected = $date->setTimezone($user->timezone);

    expect($expected)->toEqual(Timezone::toLocal($date))
        ->and($expected)->toEqual(to_local_timezone($date));
});

it('can convert date to local time formatted', function (?string $format) {
    $user = logIn();
    $date = CarbonImmutable::create(2000, 4, 1, 15);
    $expected = $date->setTimezone($user->timezone);
    $format = $format ?? config('timezone.format');

    expect($expected->format($format))->toEqual(Timezone::toLocalFormatted($date, $format));
})->with([
    'using default format' => null,
    'just days' => 'Y-m-d',
    'day and time' => 'Y-m-d g:ia',
]);

it('can make local today', function () {
    $user = logIn();
    $date = today($user->timezone);

    expect($date)->toEqual(local_today());
});


it('can make local now', function () {
    $user = logIn();
    $date = now($user->timezone)
        ->startOfMinute();

    expect($date)->toEqual(local_now()->startOfMinute());
});
