<?php

namespace Database\Factories;

use App\Models\Homework;
use App\Models\Lesson;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class HomeworkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Homework::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pupil_id'    => User::pupils()->inRandomOrder()->take(1)->first(),
            'lesson_id'   => Lesson::inRandomOrder()->take(1)->first(),
            'teacher_id'  => User::teachers()->inRandomOrder()->take(1)->first(),
            'subject_id'  => Subject::inRandomOrder()->take(1)->first(),

            'starts_at'   => $this->faker->dateTimeInInterval('-1 week', 'now'),
            'finishes_at' => $this->faker->dateTimeInInterval('now', '+1 week'),
            'sent_at'     => $this->faker->dateTimeInInterval('-1 week', 'now'),

            'message'     => $this->faker->sentence(20, true),
            'description' => $this->faker->sentence(5, true),
            'theme'       => $this->faker->sentence,
        ];
    }
}
