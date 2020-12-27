<?php

namespace App\Providers;

use App\Models\Lesson;
use App\Models\Subject;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Generator::class, function (Application $app) {
            $faker = Factory::create('ru_RU');
            $faker->seed(1_000);

            return $faker;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'subject' => Subject::class,
            'lesson' => Lesson::class,
        ]);
    }
}
