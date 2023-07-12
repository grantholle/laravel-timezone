<?php

namespace GrantHolle\Timezone\Tests\Drivers;

use Illuminate\Support\Fluent;
use Stevebauman\Location\Drivers\Driver;
use Stevebauman\Location\Position;
use Stevebauman\Location\Request;

class LocalTestDriver extends Driver
{

    protected function process(Request $request): Fluent|false
    {
        return new Fluent([
            'countryCode' => 'US',
            'city' => 'Los Angeles',
            'timezone' => 'America/Los_Angeles',
            'country' => 'United States',
        ]);
    }

    protected function hydrate(Position $position, Fluent $location): Position
    {
        $position->countryCode = $location->countryCode;
        $position->timezone = $location->timezone;
        $position->cityName = $location->city;
        $position->countryName = $location->country;
        ray($position);

        return $position;
    }
}
