<?php

use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TeachingController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\TelegramController;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\MediaLibrary\Support\MediaStream;

Auth::routes();
Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::get('/profile', 'App\Http\Controllers\Auth\ProfileController@index')
    ->name('profile')
    ->middleware('auth');

Route::get('/', [SiteController::class, 'index'])->name('main');

Route::get('/home', [HomeController::class, 'index'])->name('home');

//Teacher
Route::middleware(['auth', 'EnsureUserHasRoleTeacher'])->group(function () {
    Route::get('/teacher/lesson', [LessonController::class, 'index'])->name('teacher-lesson');
    Route::post('/teacher/lesson', [LessonController::class, 'show'])->name('teacher-lesson-filter');
    Route::get('/teacher/create-lesson', [LessonController::class, 'create'])->name('teacher-lesson-create');
    Route::post('/teacher/store-lesson', [LessonController::class, 'store'])->name('teacher-lesson-store');
    Route::get('/teacher/edit-lesson/{id}', [LessonController::class, 'edit'])->name('teacher-lesson-edit');
    Route::post('/teacher/edit-lesson/{id}', [LessonController::class, 'update'])->name('teacher-lesson-update');
    Route::get('/teacher/delete-lesson/{id}', [LessonController::class, 'destroy'])->name('teacher-lesson-delete');
    Route::get('/lesson/download/{id}', function ($id) {
        $model = Lesson::find($id);
        return MediaStream::create('lesson-files.zip')->addMedia($model->getMedia('files'));
    })->name('download');
});

// Telegram bot
Route::post('/' . config('telegram.bots.mybot.token') . '/webhook', [TelegramController::class, "webhook"]);

Route::post("/telegram/bot/add", [TelegramController::class, "addBot"])
    ->name("addTelegramBot")
    ->middleware('auth');

Route::delete("/telegram/bot/del", [TelegramController::class, "deleteBot"])
    ->name("delTelegramBot")
    ->middleware('auth');

// Учительская
Route::get('/teaching', [TeachingController::class, 'index']);

// Домашние задания
Route::get('/homework', [HomeworkController::class, 'index']);
