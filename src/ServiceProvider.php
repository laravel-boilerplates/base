<?php

namespace LaravelBoilerplates\BaseBoilerplate;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\Menu;
use LaravelBoilerplates\BaseBoilerplate\Facades\BaseBoilerplateFacade;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/boilerplate-base.php' => config_path('boilerplate-base.php'),
            ], 'config');

            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/boilerplate-base.php', 'boilerplate-base');

        // Register the main class to use with the facade
        $this->app->singleton(BaseBoilerplateFacade::class, function () {
            return new Base;
        });

        // Register a global menu.
        $this->app->singleton('menu.base', function () {
            Menu::macro('base', function() {
                return Menu::new();
            });

            return Menu::base();
        });
    }
}
