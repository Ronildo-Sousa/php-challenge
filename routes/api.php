<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::name('api.')->group(function () {
    Route::apiResource('products', ProductController::class)->middleware('hasApiKey');
});
