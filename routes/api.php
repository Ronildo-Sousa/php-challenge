<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::name('api.')->group(function () {
    Route::middleware(['auth'])->group(function (){
        Route::post('/register-admin', [UserController::class, 'storeAdmin'])->name('users.store-admin');
    });
    Route::apiResource('products', ProductController::class);
    Route::apiResource('users', UserController::class);
});
