<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        $this->registerPolicies();


        // Gate for superadmin only
        Gate::define('superadmin-only', function (User $user) {
            return $user->role === 'superadmin';
        });

        // Gate for admin only
        Gate::define('admin-only', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
