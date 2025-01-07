<?php

namespace Hashcode\laravelInstaller\Providers;

use Hashcode\laravelInstaller\Middleware\InstallerMiddleware;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class LaravelInstallerServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        // Load Routes
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'laravelInstaller');

        // Published assets
        $this->publishes([
            __DIR__ . '/../Resources/assets' => public_path('vendor/laravel-installer')
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/../config/laravelinstaller.php',
            'laravelinstaller'
        );

        $this->publishes([
            __DIR__ . '/../config/laravelinstaller.php' => config_path('laravelinstaller.php'),
        ], 'laravel-installer');

        // Register middleware
        $this->app['router']->pushMiddlewareToGroup('installer', InstallerMiddleware::class);
    }
}
