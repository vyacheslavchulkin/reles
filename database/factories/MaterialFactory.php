<?php

namespace Database\Factories;

use App\Models\Material;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Material::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'teacher_id'  => User::teachers()->inRandomOrder()->take(1)->first(),
            'name'        => $this->faker->sentence(5, true),
            'description' => $this->faker->sentence,
        ];
    }
}
