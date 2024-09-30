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

        foreach (['owner', 'admin', 'cashier'] as $role) {
            Gate::define("{$role}-only", fn(User $user) => $user->role === $role);
        }

        // // Gate for owner only
        // Gate::define('owner-only', function (User $user) {
        //     return $user->role === 'owner';
        // });

        // // Gate for admin only
        // Gate::define('admin-only', function (User $user) {
        //     return $user->role === 'admin';
        // });


        // Gate::define('cashier-only', function (User $user) {
        //     return $user->role === 'cashier';
        // });
    }
}
