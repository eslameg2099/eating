<?php

return [
    'name' => 'Kitchen Name Required',
    '%name%' => 'Kitchen Name Required',
    'description' => 'description is Required',
    '%description%' => 'description is Required',
    'address' => 'address is Required',
    '%address%' => 'address is Required',
    'permission' => 'Manage Kitchens',
    'attributes' => [
        'kitchen_id' => 'kitchen id',
        'name' => 'kitchen Name',
        'description' => 'Kitchen Description',
        'address' => 'Kitchen Address',
        'city_id' => 'Kitchen City',
        'lonq' => 'Kitchen Longitude',
        'lat' => 'Kitchen Latitude',
        'cookable_type' => 'Provider type',

    ],
    'messages' => [
        'not-found' => 'Kitchen Not Found.',
    ],
    'types' => [
        'kitchen' => 'Kitchen',
        'foodtruck' => 'Food-truck'
    ]


];
