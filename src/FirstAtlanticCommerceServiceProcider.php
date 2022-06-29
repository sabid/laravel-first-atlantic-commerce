<?php

namespace Jordanbain\FirstAtlanticCommerce;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class FirstAtlanticCommerceServiceProcider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FirstAtlanticCommerce::class, function ($app) {
            return new FirstAtlanticCommerce($app['config']['fac']);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/fac.php' => config_path('fac.php'),
        ]);
    }

    /**
    * Get the services provided by the provider
    * @return array
    */
    public function provides()
    {
        return [FirstAtlanticCommerce::class];
    }
}
