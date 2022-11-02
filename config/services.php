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
    'sendgrid' => [
        'apikey' => env('SENDGRID_APIKEY'),
        'sendgrid_free_users_list_id' => env('SENDGRID_FREE_USERS_LIST_ID'),
        'sendgrid_paid_users_list_id' => env('SENDGRID_PAID_USERS_LIST_ID')
    ],
    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],
    'integromat' => [
        'cancel_subscription' => env('INTEGROMAT_HOOK_CANCEL_SUBSCRIPTION_URL'),
        'users_cant_pay' => env('INTEGROMAT_HOOK_USERS_CANT_PAY_URL')
    ],
    'paypal' => [
        'sandbox' => array(
            'base_url' => 'https://api-m.sandbox.paypal.com',
            'client_id' => env('PAYPAL_CLIENT_ID_SANDBOX'),
            'secret_id' => env('PAYPAL_SECRET_SANDBOX')
        ),
        'production' => array(
            'base_url' => 'https://api-m.paypal.com',
            'client_id' => env('PAYPAL_CLIENT_ID_PRODUCTION'),
            'secret_id' => env('PAYPAL_SECRET_PRODUCTION')
        ),
    ],
    'bing' => [
        'api_key' => env('BING_API_KEY'),
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
    ],
    'spotify' => [
        'main' => [
            'client_id' => env('SPOTIFY_MAIN_CLIENT_ID'),
            'client_secret' => env('SPOTIFY_MAIN_CLIENT_SECRET'),
        ],
        'api_key1' => [
            'client_id1' => env('SPOTIFY_CLIENT_ID1'),
            'client_secret1' => env('SPOTIFY_CLIENT_SECRET1'),
        ],
        'api_key2' => [
            'client_id2' => env('SPOTIFY_CLIENT_ID2'),
            'client_secret2' => env('SPOTIFY_CLIENT_SECRET2'),
        ],
        'api_key3' => [
            'client_id3' => env('SPOTIFY_CLIENT_ID3'),
            'client_secret3' => env('SPOTIFY_CLIENT_SECRET3'),
        ],
        'api_key4' => [
            'client_id4' => env('SPOTIFY_CLIENT_ID4'),
            'client_secret4' => env('SPOTIFY_CLIENT_SECRET4'),
        ],
        'api_key5' => [
            'client_id5' => env('SPOTIFY_CLIENT_ID5'),
            'client_secret5' => env('SPOTIFY_CLIENT_SECRET5'),
        ],
        'api_key6' => [
            'client_id6' => env('SPOTIFY_CLIENT_ID6'),
            'client_secret6' => env('SPOTIFY_CLIENT_SECRET6'),
        ],
        'api_key7' => [
            'client_id7' => env('SPOTIFY_CLIENT_ID7'),
            'client_secret7' => env('SPOTIFY_CLIENT_SECRET7'),
        ],
        'api_key8' => [
            'client_id8' => env('SPOTIFY_CLIENT_ID8'),
            'client_secret8' => env('SPOTIFY_CLIENT_SECRET8'),
        ],
        'api_key9' => [
            'client_id9' => env('SPOTIFY_CLIENT_ID9'),
            'client_secret9' => env('SPOTIFY_CLIENT_SECRET9'),
        ],
        'api_key10' => [
            'client_id10' => env('SPOTIFY_CLIENT_ID10'),
            'client_secret10' => env('SPOTIFY_CLIENT_SECRET10'),
        ],
    ]
];
