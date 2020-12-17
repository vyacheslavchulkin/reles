<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeworkTable extends Migration
{
    public function up(): void
    {
        Schema::create('homework', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pupil_id')->comment('');
            $table->unsignedBigInteger('lesson_id')->comment('');
            $table->unsignedBigInteger('teacher_id')->comment('');
            $table->unsignedBigInteger('subject_id')->comment('');

            $table->date('starts_at')->comment('Дата постановки задания');
            $table->date('finishes_at')->comment('Крайняя сдача домашки');
            $table->dateTime('sent_at')->comment('Когда ученик сдал домашку');
            /**
             * Для прикрепления файлов есть отличный пакет https://github.com/spatie/laravel-medialibrary
             * Очень рекомендую использовать его в проекте
             */
            //$table->string('file_path')->nullable()->comment('');
            $table->text('message')->comment('');
            $table->text('description')->comment('');
            $table->string('theme')->comment('');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homework');
    }
}
