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
            $table->unsignedBigInteger('grade_id')->comment('');
            $table->string('theme')->comment('');
            $table->text('description')->comment('');

            //$table->string('video_link')->comment('');
            //$table->string('video_password')->comment('');
            $table->dateTime('starts_at')->comment('Дата начала урока');
            $table->dateTime('finishes_at')->comment('Дата окончания урока');

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
