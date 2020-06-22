<?php

namespace LaravelBoilerplates\BaseBoilerplate;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use LaravelBoilerplates\BaseBoilerplate\Facades\BaseBoilerplateFacade;

use Spatie\Menu\Laravel\Menu;

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
        $this->loadViewsFrom(__DIR__.'/Views', 'base');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/boilerplate-base.php' => config_path('boilerplate-base.php'),
            ], 'config');

            // $this->commands([]);
        }

        if (!Collection::hasMacro('paginate')) {
            Collection::macro('paginate', function ($perPage = 15, $page = null, $options = []) {
                $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                return (new LengthAwarePaginator($this->forPage($page, $perPage)->values()->all(), $this->count(), $perPage, $page, $options))->withPath('');
            });
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
                return Menu::new()
                  ->addClass('navbar-nav')
                  ->link('/', 'Home');
            });

            return Menu::base();
        });
    }
}
