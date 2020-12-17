<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Subject;
use App\Models\Video;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subject::factory()->count(10)->create()->each(function (Subject $subject) {
            $subject->materials()->attach(
                Material::factory()->count(5)->create()
            );

            $subject->videos()->attach(
                Video::factory()->count(5)->create()
            );
        });
    }
}
