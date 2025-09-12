<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Plugin Options
    |--------------------------------------------------------------------------
    */
    'api_key' => env('GOOGLE_MAPS_API_KEY', ''),

    'default_location' => [
        'lat' => 0,
        'lng' => 0,
    ],

    'default_zoom' => 8,

    'default_draggable' => true,

    'default_clickable' => false,

    'default_height' => '400px',

    'my_location_button' => 'My location',

];
