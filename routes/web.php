<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiteController;

Auth::routes();

Route::get('/', [SiteController::class, 'index']);

Route::get("/hello", function () {
    return "<h1>Hello, world!</h1>";
});

Route::get('/home', [HomeController::class, 'index'])->name('home');


//Route::post('/' . env('TELEGRAM_BOT_TOKEN') . '/webhook', function () {
//    $update = Telegram::commandsHandler(true);
//});
