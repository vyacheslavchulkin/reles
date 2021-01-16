<?php

namespace Database\Seeders;

use App\Models\Homework;
use App\Models\User;
use Illuminate\Database\Seeder;

class HomeworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::pupils()->get()->each(function (User $user) {
            Homework::factory()->count(10)->create([
                'pupil_id' => $user->id,
            ]);
        });
    }
}
