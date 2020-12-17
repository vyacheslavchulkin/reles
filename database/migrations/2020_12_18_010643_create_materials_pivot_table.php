<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsPivotTable extends Migration
{
    public function up(): void
    {
        Schema::create('materials_pivot', function (Blueprint $table) {
            $table->unsignedBigInteger('material_id');
            $table->morphs('object');

            $table->foreign('material_id')
                  ->references('id')
                  ->on('materials')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials_pivot');
    }
}
