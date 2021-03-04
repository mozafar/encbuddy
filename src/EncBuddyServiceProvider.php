<?php

namespace Mozafar\EncBuddy;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class EncBuddyServiceProvider extends ServiceProvider
{
    /**
     * Publishes configuration file.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('encbuddy.php'),
        ], 'encbuddy-config');

        Route::mixin(new EncBuddyRouteMethods);
    }

    /**
     * Make config publishment optional by merging the config from the package.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config.php',
            'encbuddy'
        );
    }
}
