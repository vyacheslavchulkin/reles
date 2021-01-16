<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::get('/profile', 'App\Http\Controllers\Auth\ProfileController@index')
    ->name('profile')
    ->middleware('auth');

Route::get('/', [SiteController::class, 'index'])->name('main');

Route::get('/home', [HomeController::class, 'index'])->name('home');

//Teacher
Route::get('/teacher/lesson', [LessonController::class, 'index'])
    ->name('teacher-lesson')
    ->middleware('auth')
    ->middleware('EnsureUserHasRoleTeacher');

Route::post('/teacher/lesson', [LessonController::class, 'show'])
    ->name('teacher-lesson-filter')
    ->middleware('auth')
    ->middleware('EnsureUserHasRoleTeacher');

Route::get('/teacher/create-lesson', [LessonController::class, 'create'])
    ->name('teacher-lesson-create')
    ->middleware('auth')
    ->middleware('EnsureUserHasRoleTeacher');

Route::post('/teacher/store-lesson', [LessonController::class, 'store'])
    ->name('teacher-lesson-store')
    ->middleware('auth')
    ->middleware('EnsureUserHasRoleTeacher');

Route::get('/teacher/edit-lesson/{id}', [LessonController::class, 'edit'])
    ->name('teacher-lesson-edit')
    ->middleware('auth')
    ->middleware('EnsureUserHasRoleTeacher');

Route::post('/teacher/edit-lesson/{id}', [LessonController::class, 'update'])
    ->name('teacher-lesson-update')
    ->middleware('auth')
    ->middleware('EnsureUserHasRoleTeacher');

Route::get('/teacher/delete-lesson/{id}', [LessonController::class, 'destroy'])
    ->name('teacher-lesson-delete')
    ->middleware('auth')
    ->middleware('EnsureUserHasRoleTeacher');


// Telegram bot
Route::post('/' . config('telegram.bots.mybot.token') . '/webhook', [TelegramController::class, "webhook"]);

Route::post("/telegram/bot/add", [TelegramController::class, "addBot"])
    ->name("addTelegramBot")
    ->middleware('auth');

Route::delete("/telegram/bot/del", [TelegramController::class, "deleteBot"])
    ->name("delTelegramBot")
    ->middleware('auth');
