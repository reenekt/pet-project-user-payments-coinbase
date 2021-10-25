<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Laravel money
     |--------------------------------------------------------------------------
     */
    'locale' => config('app.locale', 'en_US'),
    'defaultCurrency' => config('app.currency', 'USD'),
    'currencies' => [
        'iso' => 'all',
        'bitcoin' => 'all',
        'custom' => [
            'BTC' => 8, // 'bitcoin' above uses 'XBT', see https://github.com/moneyphp/money/issues/552 for details
            'DOGE' => 8,
        ],
    ],
];
