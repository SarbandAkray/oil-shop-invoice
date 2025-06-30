<?php

namespace App\Providers;

use App\Console\Commands\MyCommand;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //

        $this->app->extend('command.pennant.purge', function () {
            return new MyCommand();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //

    }
}


