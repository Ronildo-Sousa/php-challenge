<?php

use App\Actions\Products\ImportFromOpenFoodFacts;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    (new ImportFromOpenFoodFacts)->run();
    // ImportFromOpenFoodFactsJob::dispatch();
    return view('welcome');
});
