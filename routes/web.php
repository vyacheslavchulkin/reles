<?php

use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TeachingController;
use App\Http\Controllers\HomeworkController;

Auth::routes();

Route::get('/', [SiteController::class, 'index']);

Route::get("/hello", function () {
    return "<h1>Hello, world!</h1>";
});

Route::get('/home', [HomeController::class, 'index'])->name('home');


// Telegram bot
Route::post('/' . config('telegram.bots.mybot.token') . '/webhook', [TelegramController::class, "webhook"]);

// Учительская
Route::get('/teaching', [TeachingController::class, 'index']);

// Домашние задания
Route::get('/homework', [HomeworkController::class, 'index']);
