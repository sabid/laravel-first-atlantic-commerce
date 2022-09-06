<?php

namespace Jordanbain\FirstAtlanticCommerce;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class FirstAtlanticCommerceServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(Card::class, function ($app) {
            return new Card();
        });

        $this->app->bind(IsAlive::class, function ($app) {
            return new IsAlive();
        });

        $this->app->bind(Queries::class, function ($app) {
            return new Queries();
        });

        $this->app->bind(TermMgmt::class, function ($app) {
            return new TermMgmt();
        });

        $this->app->bind(ThreeDSecure::class, function ($app) {
            return new ThreeDSecure();
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
        return [
            Card::class,
            IsAlive::class,
            Queries::class,
            TermMgmt::class,
            ThreeDSecure::class,
        ];
    }
}
