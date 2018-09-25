<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Redis;
use Auth0\Login\Contract\Auth0UserRepository as Auth0Contract;
use Auth0\Login\Repository\Auth0UserRepository as UserRepo;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Redis::get('available_tickets') === null) {
            Redis::set('available_tickets', '50');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            Auth0Contract::class,
            UserRepo::class
        );
    }
}
