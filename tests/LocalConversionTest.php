<?php

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use GrantHolle\Timezone\Facades\Timezone;
use Illuminate\Support\Facades\Config;

it('can detect user timezone', function (string $timezone) {
    expect(timezone())->toEqual($timezone);
})->with([
    'a user that has a timezone' => fn () => logIn()->timezone,
    'a user without a timezone' => function () {
        logIn(['timezone' => null]);

        return 'UTC';
    },
]);

it('can convert date to local time object', function () {
    $user = logIn();
    $date = CarbonImmutable::create(2000, 4, 1, 15);
    $expected = $date->setTimezone($user->timezone);

    expect($expected)->toEqual(Timezone::toLocal($date));
});

it('can display in the fallback timezone', function () {
    $user = logIn(['timezone' => null]);
    Config::set('timezone.fallback', 'Asia/Shanghai');
    $date = CarbonImmutable::create(2000, 4);
    $converted = $date->setTimezone('Asia/Shanghai');

    expect($user->timezone)->toBeNull()
        ->and(to_local_timezone($date))
        ->toBe($converted->format(config('timezone.format')));
});

it('can convert date to local time formatted', function (?string $format) {
    $user = logIn();
    $date = CarbonImmutable::create(2000, 4, 1, 15);
    $format = $format ?? config('timezone.format');
    $expected = $date->setTimezone($user->timezone)
        ->format($format);

    expect($expected)->toEqual(Timezone::toLocalFormatted($date, $format))
        ->and($expected)->toEqual(to_local_timezone($date, $format));
})->with([
    'using default format' => null,
    'just days' => 'Y-m-d',
    'day and time' => 'Y-m-d g:ia',
]);

it('can convert from local timezone', function () {
    $user = logIn(['timezone' => 'Asia/Shanghai']);
    $userDate = Carbon::now($user->timezone);
    $converted = from_local_timezone($userDate);

    expect($userDate->toDateTimeString())
        ->not()->toEqual($converted->toDateTimeString());
});

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
