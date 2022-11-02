<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [
    /*
      |--------------------------------------------------------------------------
      | Default Log Channel
      |--------------------------------------------------------------------------
      |
      | This option defines the default log channel that gets used when writing
      | messages to the logs. The name specified in this option should match
      | one of the channels defined in the "channels" configuration array.
      |
     */

    'default' => env('LOG_CHANNEL', 'stack'),
    /*
      |--------------------------------------------------------------------------
      | Log Channels
      |--------------------------------------------------------------------------
      |
      | Here you may configure the log channels for your application. Out of
      | the box, Laravel uses the Monolog PHP logging library. This gives
      | you a variety of powerful log handlers / formatters to utilize.
      |
      | Available Drivers: "single", "daily", "slack", "syslog",
      |                    "errorlog", "monolog",
      |                    "custom", "stack"
      |
     */
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],
        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
        ],
        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => env('LOG_LEVEL', 'critical'),
        ],
        'papertrail' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],
        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],
        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],
        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],
        'spotify_playlists_updating' => [
            'driver' => 'single',
            'path' => storage_path('logs/spotify_playlists_updating.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        'stripe' => [
            'driver' => 'single',
            'path' => storage_path('logs/stripe.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        'paypal' => [
            'driver' => 'single',
            'path' => storage_path('logs/paypal.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        'subscriptions' => [
            'driver' => 'single',
            'path' => storage_path('logs/subscriptions.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        'playlist_crawler' => [
            'driver' => 'single',
            'path' => storage_path('logs/playlist_crawler.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        'spotify_playlists_updating' => [
            'driver' => 'single',
            'path' => storage_path('logs/crawler_spotify_playlists_updating.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        'spotify_api' => [
            'driver' => 'single',
            'path' => storage_path('logs/spotify_api.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        'crawler_validating_email' => [
            'driver' => 'single',
            'path' => storage_path('logs/crawler_validating_email.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        'crawler_spotify_users' => [
            'driver' => 'single',
            'path' => storage_path('logs/crawler_spotify_users.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        'crawler_spotify_users_all' => [
            'driver' => 'single',
            'path' => storage_path('logs/crawler_spotify_users_all.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],
    ],
];
