<?php

namespace GrantHolle\Timezone;

use GrantHolle\Timezone\Listeners\SetTimezoneListener;
use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TimezoneServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-timezone')
            ->hasConfigFile()
            ->hasMigration('add_timezone_to_users_table');
    }

    public function packageRegistered()
    {
        $events = config('timezone.events');

        if (!empty($events)) {
            Event::listen($events, SetTimezoneListener::class);
        }
    }
}
