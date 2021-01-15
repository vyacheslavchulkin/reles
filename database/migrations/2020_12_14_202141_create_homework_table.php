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

            $table->unsignedBigInteger('pupil_id')->comment('Идентификатор ученика');
            $table->unsignedBigInteger('lesson_id')->comment('Идентификатор урока');
            $table->unsignedBigInteger('teacher_id')->comment('Идентификатор учителя');
            $table->unsignedBigInteger('subject_id')->comment('Идентификатор темы');

            $table->date('starts_at')->comment('Дата постановки задания');
            $table->date('finishes_at')->comment('Крайняя сдача домашнего задания');
            $table->dateTime('sent_at')->nullable()->comment('Когда ученик сдал домашку');
            $table->text('message')->nullable()->comment('Сопроводительное сообщение');
            $table->text('description')->nullable()->comment('Описание');
            $table->string('theme')->nullable()->comment('Тема');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homework');
    }
}
