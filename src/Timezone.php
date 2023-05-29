<?php

namespace GrantHolle\Timezone;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use DateTimeZone;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use IntlTimeZone;

class Timezone
{
    public function getCurrentTimezone(): string
    {
        $fallback = config('timezone.fallback') ?: config('app.timezone');

        if ($timezone = Auth::user()?->timezone ?? null) {
            return $timezone;
        }

        return $fallback;
    }

    public function timezones(?string $timezone = null): Collection|string
    {
        $zones = collect(DateTimeZone::listIdentifiers())
            ->mapWithKeys(function ($zoneId) {
                $zone = IntlTimeZone::createTimeZone($zoneId);
                $name = $zone->getDisplayName($zone->useDaylightTime());
                $cleaned = str_replace('_', ' ', $zoneId);

                return [
                    $zoneId => "{$cleaned} ({$name})",
                ];
            });

        if (is_null($timezone)) {
            return $zones;
        }

        return $zones->get($timezone);
    }

    public function toLocal(null|Carbon|CarbonImmutable $date, string $format = null): string|CarbonImmutable
    {
        $date = $date ?? now();

        $converted = CarbonImmutable::make($date)
            ->setTimezone($this->getCurrentTimezone());

        if (!$format) {
            return $converted;
        }

        return $converted->format($format);
    }

    public function toLocalFormatted(null|Carbon|CarbonImmutable $date, string $format = null): string
    {
        $date = $date ?? now();

        return $this->toLocal($date, $format ?? config('timezone.format'));
    }

    public function fromLocal(mixed $date): CarbonImmutable
    {
        return CarbonImmutable::parse($date, $this->getCurrentTimezone())
            ->setTimezone(config('app.timezone'));
    }

    public function today(): CarbonImmutable
    {
        return CarbonImmutable::today($this->getCurrentTimezone());
    }

    public function now(): CarbonImmutable
    {
        return CarbonImmutable::now($this->getCurrentTimezone());
    }
}
