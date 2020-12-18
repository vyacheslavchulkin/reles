<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'phone'             => $this->faker->phoneNumber,
            //'photo_path'        => $this->faker->image(storage_path('avatars')),
            'user_type'         => $this->faker->randomElement([1, 2, 3]),
            'name'              => $this->faker->firstName,
            'surname'           => $this->faker->lastName,
            'patronymic'        => $this->faker->middleName,
            'description'       => $this->faker->sentence(3),
            'email'             => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
        ];
    }

    public function admin(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type' => 1,
            ];
        });
    }

    public function teacher(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                //'subject_id' => 1,
                //'lesson_id' => 1,
                'user_type' => 2,
            ];
        });
    }

    public function pupil(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type' => 3,
            ];
        });
    }
}
