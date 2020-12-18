<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToHomeworkTable extends Migration
{
    public function up(): void
    {
        Schema::table('homework', function (Blueprint $table) {
            $table->foreign('pupil_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->foreign('lesson_id')
                  ->references('id')
                  ->on('lessons')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->foreign('teacher_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->foreign('subject_id')
                  ->references('id')
                  ->on('subjects')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('homework', function (Blueprint $table) {
            $table->dropForeign(['pupil_id']);
            $table->dropForeign(['lesson_id']);
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['subject_id']);
        });
    }
}
