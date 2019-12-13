<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'paypal' => [
        'username' => 'sb-8j5qc740358_api1.business.example.com',
        'password' => 'X5BZ6HJCPZCDR22M',
        'signature' => 'AQxfEyfDVwEJUTRkJi7QbvY5CMohAMyHvt7Jeg4U82egdVHm-GYySZJo',
        'sandbox' => true,
        'clientId' => 'AQ9pm_DWX1G6bbVU6glc8N8SvUcwvnCaAlugL4paoqrY_DA-T5qNwj7rwiIPbVM5JBPbUI02Wi7tvWQ8',
        'secret' => 'EPSG6HzDIq6doCeIr5UuquceB7_MkxSFuZAIYX3xkrzQ_W45B_Gg9BP0z0u4qlHLpNg8huPO67HCnzqE',
        'live' => true,
    ],

];
