<?php

namespace Alzpk\LaravelChangeLog;

use Illuminate\Support\ServiceProvider;

class ChangeLogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {

    }
}
