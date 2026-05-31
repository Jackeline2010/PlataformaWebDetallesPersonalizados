<?php

return [

    'env' => env('NIUBIZ_ENV', 'sandbox'),

    'merchant_id' => env('NIUBIZ_MERCHANT_ID'),

    'user' => env('NIUBIZ_USER'),

    'password' => env('NIUBIZ_PASSWORD'),

    'api_key' => env('NIUBIZ_API_KEY'),

    'currency' => env('NIUBIZ_CURRENCY', 'USD'),

    'channel' => env('NIUBIZ_CHANNEL', 'web'),

    'sandbox' => [
        'base_url' => 'https://apisandbox.vnforappstest.com',

        'js_url' => 'https://static-content-qas.vnforapps.com/v2/js/checkout.js',
    ],

    'production' => [
        'base_url' => 'https://apiprod.vnforapps.com',

        'js_url' => 'https://static-content.vnforapps.com/v2/js/checkout.js',
    ],

];
