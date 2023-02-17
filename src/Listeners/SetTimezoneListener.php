<?php

namespace GrantHolle\Timezone\Listeners;

use Illuminate\Auth\Events\Login;
use Stevebauman\Location\Facades\Location;

class SetTimezoneListener
{
    public function handle(Login $event): void
    {
        if (
            (!$event->user->timezone || config('timezone.overwrite')) &&
            $position = Location::get()
        ) {
            $event->user->timezone = $position->timezone;
            $event->user->save();
        }
    }
}
