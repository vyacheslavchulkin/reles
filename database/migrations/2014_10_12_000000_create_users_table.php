<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        /**
         * Чтобы упростить внедрение авторизации, лучше использовать одну таблицу для хранения пользователей
         */
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('subject_id')->nullable()->comment('');
            $table->unsignedBigInteger('lesson_id')->nullable()->comment('');
            /**
             * Добавил поле, отвечающее за тип пользователя, можно сделать отдельную таблицу для хранения типов или сделать enum
             */
            $table->unsignedSmallInteger('user_type')->comment('');
            /**
             * Для прикрепления файлов есть отличный пакет https://github.com/spatie/laravel-medialibrary
             * Очень рекомендую использовать его в проекте
             */
            $table->string('photo_path')->nullable()->comment('');
            $table->string('phone')->comment('');

            $table->string('name');
            $table->string('surname');
            $table->string('patronymic');
            $table->text('description');
            /**
             * Используйте вместо поля login email пользователя при авторизации
             */
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
