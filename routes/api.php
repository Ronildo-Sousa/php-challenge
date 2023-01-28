<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::name('api.')->group(function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('users', UserController::class);
});
