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

            $table->unsignedSmallInteger('user_type')->comment('');
            $table->string('phone')->comment('');

            $table->string('name');
            $table->string('surname');
            $table->string('patronymic');
            $table->text('description');

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
