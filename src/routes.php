<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => '\Lefamed\LaravelBillwerk\Http\Controllers'], function () {
	require __DIR__ . '/routes/api.php';
});
