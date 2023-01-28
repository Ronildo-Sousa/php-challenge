<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::name('api.')->group(function () {
    Route::middleware(['auth'])->group(function (){
        Route::post('/register-admin', [AuthController::class, 'registerAdmin'])->name('auth.register-admin');
        Route::apiResource('users', UserController::class);
    });
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'register'])->name('auth.register');
    Route::apiResource('products', ProductController::class);
});
