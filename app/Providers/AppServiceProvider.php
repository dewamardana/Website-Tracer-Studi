<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Gate::define('admin', function (User $user) {
            return in_array('admin', $user->role ?? []);
        });

        Gate::define('dosen', function (User $user) {
            return in_array('dosen', $user->role ?? []);
        });

        
    }
}
