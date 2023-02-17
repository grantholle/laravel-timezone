<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Overwrite Existing Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may configure if you would like to overwrite existing
    | timezones if they have been already set in the database.
    |
    */

    'overwrite' => false,

    /*
    |--------------------------------------------------------------------------
    | Overwrite Default Format
    |--------------------------------------------------------------------------
    |
    | Set the default format for displaying dates.
    |
    */

    'format' => 'jS F Y g:i:a',

    /*
    |--------------------------------------------------------------------------
    | Lookup Array
    |--------------------------------------------------------------------------
    |
    | The lookup array that will be used to detect the user's IP address.
    |
    */

    'lookup' => [
        'server' => [
            'REMOTE_ADDR',
        ],
        'headers' => [

        ],
    ],
];

