<?php

namespace Hashcode\laravelInstaller\Providers;

use Hashcode\laravelInstaller\Middleware\InstallerMiddleware;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class LaravelInstallerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Merge default config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/laravelinstaller.php',
            'laravelinstaller'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Load Routes
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');

        // Load Views
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'laravelInstaller');

        // Publish Assets
        $this->publishes([
            __DIR__ . '/../Resources/assets' => public_path('vendor/laravel-installer'),
        ], 'laravel-installer-assets');

        // Publish Config File
        $this->publishes([
            __DIR__ . '/../config/laravelinstaller.php' => config_path('laravelinstaller.php'),
        ], 'laravel-installer-config');

        // Register Middleware
        $router = $this->app['router'];
        if (method_exists($router, 'middlewareGroup')) {
            $router->pushMiddlewareToGroup('installer', InstallerMiddleware::class);
        }
    }
}
