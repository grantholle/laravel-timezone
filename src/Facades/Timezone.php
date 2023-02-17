<?php

namespace GrantHolle\Timezone\Facades;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getCurrentTimezone()
 * @method static string|Collection timezones(?string $timezone = null)
 * @method static string|CarbonImmutable toLocal(null|Carbon|CarbonImmutable $date, string $format = null)
 * @method static string toLocalFormatted(null|Carbon|CarbonImmutable $date, string $format = null)
 * @method static CarbonImmutable fromLocal(mixed $date)
 * @method static CarbonImmutable today()
 * @method static CarbonImmutable now()
 *
 * @see \GrantHolle\Timezone\Timezone
 */
class Timezone extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \GrantHolle\Timezone\Timezone::class;
    }
}
