<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->admin()->count(1)->create();
        User::factory()->teacher()->count(5)->create();
        User::factory()->pupil()->count(100)->create();
    }
}
