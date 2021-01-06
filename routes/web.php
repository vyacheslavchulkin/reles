<?php

use App\Http\Controllers\LessonController;
use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiteController;

Auth::routes();

Route::get('/', [SiteController::class, 'index']);

Route::get("/hello", function () {
    return "<h1>Hello, world!</h1>";
});

Route::get('/home', [HomeController::class, 'index'])->name('home');


//Teacher
Route::get('/teacher/lessons', [LessonController::class, 'index']);
Route::get('/teacher/create-lesson', [LessonController::class, 'create']);
Route::post('/teacher/store-lesson', [LessonController::class, 'store']);
Route::get('/teacher/delete-lesson/{id}', [LessonController::class, 'delete']);

// Telegram bot
Route::post('/' . config('telegram.bots.mybot.token') . '/webhook', [TelegramController::class, "webhook"]);
