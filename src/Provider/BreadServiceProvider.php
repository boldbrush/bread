<?php

namespace BoldBrush\Bread\Provider;

use Illuminate\Support\ServiceProvider;

class BreadServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            realpath(dirname(dirname(__DIR__))) . '/config/bread.php',
            'bread'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(
            realpath(dirname(dirname(__DIR__))) . '/resources/views',
            'bread'
        );

        $this->publishes([
            realpath(dirname(dirname(__DIR__))) . '/config/bread.php' => config_path('bread.php'),
            realpath(dirname(dirname(__DIR__))) . '/resources/views' => resource_path('views/vendor/bread'),
        ]);
    }
}