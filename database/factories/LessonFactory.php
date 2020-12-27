<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lesson::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subject_id' => Subject::inRandomOrder()->take(1)->first(),
            'teacher_id'  => User::teachers()->inRandomOrder()->take(1)->first(),
            'theme'       => $this->faker->sentence,
            'description' => $this->faker->sentence(5, true),
            /**
             * Для прикрепления файлов есть отличный пакет https://github.com/spatie/laravel-medialibrary
             * Очень рекомендую использовать его в проекте
             */
            //'video_link' => $this->faker,
            //'video_password' => $this->faker,
            'starts_at'   => $this->faker->dateTimeInInterval('-1 week', 'now'),
            'finishes_at' => $this->faker->dateTimeInInterval('now', '+1 week'),
        ];
    }
}
