<?php

namespace Mindyourteam\Core;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Mindyourteam\Core\Console\Commands\ImportTopics;
use Mindyourteam\Core\Console\Commands\ClientQuestions;
use Illuminate\Pagination\Paginator;

class ServiceProvider extends IlluminateServiceProvider
{
    protected function mergeConfigRecursiveFrom($path, $key)
    {
        $config = $this->app['config']->get($key, []);
        $this->app['config']->set($key, array_merge_recursive($config, require $path));
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->mergeConfigRecursiveFrom(
            __DIR__ . '/../config.php', 'mindyourteam'
        );
        $this->loadViewsFrom(__DIR__ . '/../views', 'mindyourteam');

        if ($this->app->runningInConsole()) {
            $this->commands([
                ImportTopics::class,
                ClientQuestions::class,
            ]);
        }
        
        Paginator::defaultView('mindyourteam::partials.pagination');
    }

    public function register()
    {
        Route::middleware('web')
            ->namespace('Mindyourteam\\Core\Controllers')
            ->group(__DIR__ . '/../routes.php');

        //$this->loadRoutesFrom(__DIR__ . '/../routes.php');
    }
}
