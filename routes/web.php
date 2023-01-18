<?php

use App\Jobs\DowloadProductsJob;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    DowloadProductsJob::dispatch("https://challenges.coode.sh/food/data/json/products_01.json.gz", 'products_01.zip');
    return view('welcome');
});
