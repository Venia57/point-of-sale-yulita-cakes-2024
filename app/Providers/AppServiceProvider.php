<?php

namespace App\Providers;

use App\Models\Kategori;
use App\Models\User;
use App\Policies\KategoriPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        
        Gate::define('admin', function(User $user) {
            return $user->is_admin === 1;
        });
        Gate::define('biasa', function(User $user) {
            return $user->is_admin === 0;
        });

    }
}
