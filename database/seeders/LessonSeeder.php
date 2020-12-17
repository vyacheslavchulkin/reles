<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\Material;
use App\Models\Video;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lesson::factory()->count(100)->create()->each(function (Lesson $lesson) {
            $lesson->materials()->attach(
                Material::factory()->count(2)->create()
            );

            $lesson->videos()->attach(
                Video::factory()->count(1)->create()
            );
        });
    }
}
