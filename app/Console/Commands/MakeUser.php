<?php

namespace App\Console\Commands;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Console\Command;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MakeUser extends Command
{
    protected $signature = 'make:user {user_type} {last_name} {first_name} {middle_name} {email} {phone} {password}';

    protected $description = 'Make user
                              {user_type : Тип пользователя}
                              {last_name : Фамилия}
                              {first_name : Имя}
                              {middle_name : Отчество}
                              {email : E-mail}
                              {phone : Телефон}
                              {password : Пароль}';

    public function handle(): void
    {
        $arguments = $this->arguments();

        try {
            $this->validator($arguments)
                 ->validate();
            $user = $this->create($arguments);
        } catch (ValidationException $exception) {
            $this->error($exception->getMessage());

            foreach ($exception->errors() as $argument => $errors) {
                foreach ($errors as $error) {
                    $this->warn($error);
                }
            }

            exit(1);
        }


        event(new Registered($user));
    }

    protected function validator(array $data): ValidatorContract
    {
        return Validator::make($data, [
            'user_type'   => [
                'required',
                Rule::in([RoleEnum::ADMIN, RoleEnum::TEACHER, RoleEnum::PUPIL]),
            ],
            'last_name'   => ['required', 'string', 'max:255'],
            'first_name'  => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'       => ['required', 'string', 'max:255'],
            'password'    => ['required', 'string', 'min:8'],
        ]);
    }

    protected function create(array $data): User
    {
        return User::create([
            'user_type'   => $data['user_type'],
            'last_name'   => $data['last_name'],
            'first_name'  => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'email'       => $data['email'],
            'phone'       => $data['phone'],
            'password'    => Hash::make($data['password']),
        ]);
    }
}
