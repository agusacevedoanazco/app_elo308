<?php

namespace App\Providers;

use App\Models\Curso;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('modevento', function (User $user) {
            return $user->roleProfesor();
        });
        Gate::define('participa', function (User $user, Curso $curso){
            return $curso->usuarios->contains($user->id);
        });
    }
}
