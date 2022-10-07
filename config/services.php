<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'hyperpay' => [
        'mode' => env('HYPER_PAY_MODE', 'test'),
        'access_token' => env('HYPER_PAY_ACCESS_TOKEN'),
        'currency' => env('HYPER_PAY_CURRENCY'),
        'notification_slack_webhook_url' => env('HYPER_PAY_NOTIFICATION_SLACK_WEBHOOK_URL'),
        'payment_methods' => [
            'visa' => [
                'type' => env('HYPER_PAY_VISA_PAYMENT_TYPE', 'DB'),
                'entity_id' => env('HYPER_PAY_VISA_ENTITY_ID'),
            ],
            'mada' => [
                'type' => env('HYPER_PAY_MADA_PAYMENT_TYPE', 'DB'),
                'entity_id' => env('HYPER_PAY_MADA_ENTITY_ID'),
            ],
            'apple' => [
                'type' => env('HYPER_PAY_APPLE_PAYMENT_TYPE', 'DB'),
                'entity_id' => env('HYPER_PAY_APPLE_ENTITY_ID'),
            ],
        ],
    ],

    'pusher' => [
        'user_beams_instance_id' => env('USER_PUSHER_BEAMS_INSTANCE_ID'),
        'user_beams_secret_key' => env('USER_PUSHER_BEAMS_SECRET_KEY'),
        'chef_beams_instance_id' => env('CHEF_PUSHER_BEAMS_INSTANCE_ID'),
        'chef_beams_secret_key' => env('CHEF_PUSHER_BEAMS_SECRET_KEY'),

    ],
    'ekhdemny' => [
        'user' => env('EKHDEMNY_USER'),
        'pass' => env('EKHDEMNY_PASS')
    ],
    'google_matrix' => env('DIRECTION_MATRIX_KEY')

];
