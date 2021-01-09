<?php

use App\Http\Controllers\LessonController;
use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiteController;

Auth::routes();
Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');


Route::get('/', [SiteController::class, 'index']);

Route::get("/hello", function () {
    return "<h1>Hello, world!</h1>";
});

Route::get('/home', [HomeController::class, 'index'])->name('home');


//Teacher
Route::get('/teacher/lesson', [LessonController::class, 'index'])->name('teacher-lesson');
Route::get('/teacher/create-lesson', [LessonController::class, 'create'])->name('teacher-lesson-create');
Route::post('/teacher/store-lesson', [LessonController::class, 'store'])->name('teacher-lesson-store');
Route::get('/teacher/delete-lesson/{id}', [LessonController::class, 'delete'])->name('teacher-lesson-delete');

// Telegram bot
Route::post('/' . config('telegram.bots.mybot.token') . '/webhook', [TelegramController::class, "webhook"]);
