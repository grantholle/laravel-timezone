<?php

use Carbon\CarbonImmutable;
use GrantHolle\Timezone\Facades\Timezone;
use Illuminate\Support\Collection;

if (!function_exists('timezone')) {
    /**
     * Gets a list of all timezones
     * or the formatted name of the given timezone
     *
     * @param string|null $timezone
     * @return Collection|string
     */
    function timezone(): string {
        return Timezone::getCurrentTimezone();
    }
}

if (!function_exists('timezones')) {
    /**
     * Gets a list of all timezones
     * or the formatted name of the given timezone
     *
     * @param string|null $timezone
     * @return Collection|string
     */
    function timezones(string $timezone = null): Collection|string {
        return Timezone::timezones($timezone);
    }
}

if (!function_exists('to_local_timezone')) {
    function to_local_timezone(null|\Carbon\Carbon|\Carbon\CarbonImmutable $date, string $format = null): ?string {
        return Timezone::toLocal($date, $format);
    }
}

if (!function_exists('local_today')) {
    function local_today(): CarbonImmutable {
        return Timezone::today();
    }
}

if (!function_exists('local_now')) {
    function local_now(): CarbonImmutable {
        return Timezone::now();
    }
}
