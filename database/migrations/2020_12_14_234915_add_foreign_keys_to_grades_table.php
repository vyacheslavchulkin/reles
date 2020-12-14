<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToGradesTable extends Migration
{
    public function up(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->foreign('teacher_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
        });
    }
}
