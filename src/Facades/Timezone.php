<?php

namespace GrantHolle\Timezone\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \GrantHolle\Timezone\Timezone
 */
class Timezone extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \GrantHolle\Timezone\Timezone::class;
    }
}
