<?php


namespace App\Providers;


use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('role', function ($role) {
            $role = strtoupper($role);
            return "<?php if(\App\Enums\RoleEnum::fromKey({$role})->is(Auth::user()->user_type)): ?>";
        });
        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });
    }


    public function register()
    {
        //
    }
}
