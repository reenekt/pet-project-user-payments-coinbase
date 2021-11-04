<?php

use Illuminate\Support\Facades\Route;

Route::prefix('coinbase')->group(function () {
    Route::prefix('webhooks')
        ->middleware(\App\Http\Middleware\CoinbaseWebhookMiddleware::class)
        ->group(function () {
            Route::any('charge', [\App\Http\Controllers\CoinbaseController::class, 'chargeWebhook']);
        });
});
