<?php

namespace App\Providers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        config(['app.locale' => 'id']);
	    Carbon::setLocale('id');


        //gate authorization untuk user yang sudah login
        Gate::define('petugas' , function(User $user){
           return $user->role === 1;
        });

        Gate::define('pimpinan' , function(User $user){
            return $user->role === 2;
        });

        Gate::define('pelanggan' , function(User $user){
            return $user->role === 3;
        });

        Gate::define('gas_pim' , function(User $user){
            return $user->role === 1 || $user->role === 2;
        });
    }
}
