<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosPivotTable extends Migration
{
    public function up(): void
    {
        Schema::create('videos_pivot', function (Blueprint $table) {
            $table->unsignedBigInteger('video_id');
            $table->morphs('object');

            $table->foreign('video_id')
                  ->references('id')
                  ->on('videos')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos_pivot');
    }
}
