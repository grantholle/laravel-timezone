<?php

namespace GrantHolle\Timezone\Listeners;

use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;

class SetTimezoneListener
{
    public function handle($event): void
    {
        if (empty(config('timezone.events'))) {
            return;
        }

        $user = $event->user ?? Auth::user();

        if (
            (!$user->timezone || config('timezone.overwrite')) &&
            $position = Location::get()
        ) {
            $user->timezone = $position->timezone;
            $user->save();
        }
    }
}
