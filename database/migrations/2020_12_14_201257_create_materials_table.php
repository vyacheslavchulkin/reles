<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id()->comment('');

            $table->unsignedBigInteger('subject_id')->comment('');
            $table->unsignedBigInteger('lesson_id')->comment('');
            $table->unsignedBigInteger('teacher_id')->comment('');
            $table->string('name')->comment('');
            $table->text('description')->comment('');
            /**
             * Для прикрепления файлов есть отличный пакет https://github.com/spatie/laravel-medialibrary
             * Очень рекомендую использовать его в проекте
             */
            $table->string('file_path')->comment('');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
}
