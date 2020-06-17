<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(config('laravel-billwerk.api.middleware'))->group(function() {
    Route::post('/billwerk/webhook', 'WebhookController@handle');

    Route::get('/contract/{contractId}/token', 'ContractController@getSelfServiceToken');
});
