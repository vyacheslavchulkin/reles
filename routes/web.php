<?php

use App\Http\Controllers\TelegramController;
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

Route::get("/hello", function () {
    return "<h1>Hello, world!</h1>";
});


// Telegram bot
Route::post('/' . config('telegram.bots.mybot.token') . '/webhook', [TelegramController::class, "webhook"]);
