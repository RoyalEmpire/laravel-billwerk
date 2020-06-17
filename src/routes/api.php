<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(config('laravel-billwerk.middleware'))->group(function() {
    Route::post('/billwerk/webhook', 'WebhookController@handle');

    // Api routes
    Route::post('/order/preview', 'Api\OrderController@preview');
    Route::post('/order', 'Api\OrderController@order');
    Route::get('/contract/{contractId}/token', 'Api\ContractController@getSelfServiceToken');
});
