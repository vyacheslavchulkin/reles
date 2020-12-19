<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;

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

Route::get('/', [SiteController::class, 'index']);

Route::post('/homework', [\App\Http\Controllers\HomeworkController::class, 'create']);

Route::get("/hello", function () {
    return "<h1>Hello, world!</h1>";
});


//Route::post('/' . env('TELEGRAM_BOT_TOKEN') . '/webhook', function () {
//    $update = Telegram::commandsHandler(true);
//});
