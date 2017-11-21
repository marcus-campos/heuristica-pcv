<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HttpsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if(env('APP_ENV') == 'production')
            $this->app['url']->forceScheme('https');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
