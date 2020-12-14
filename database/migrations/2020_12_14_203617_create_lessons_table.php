<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('subject_id')->comment('');
            $table->unsignedBigInteger('teacher_id')->comment('');
            $table->string('theme')->comment('');
            $table->text('description')->comment('');
            $table->unsignedBigInteger('material_id')->comment('');
            /**
             * Для прикрепления файлов есть отличный пакет https://github.com/spatie/laravel-medialibrary
             * Очень рекомендую использовать его в проекте
             */
            $table->string('video_link')->comment('');
            $table->string('video_password')->comment('');
            // Переименовал из date_start в starts_at, обычно так записываются даты в Laravel
            $table->date('starts_at')->comment('Дата постановки задания');
            // Переименовал из date_finish в finishes_at
            $table->date('finishes_at')->comment('Крайняя сдача домашки');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
}
