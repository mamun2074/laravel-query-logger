<?php

namespace Mahmud2074\QueryLogger;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Mahmud2074\QueryLogger\Services\QueryCollector;

class QueryLoggerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . './config/query-logger.php', 'query-logger');

        $this->app->singleton(QueryCollector::class);
    }

    public function boot()
    {
        if (!config('query-logger.enabled')) {
            return;
        }

        $this->publishes([
            __DIR__ . './config/query-logger.php' => config_path('query-logger.php'),
        ], 'config');

        DB::listen(function ($query) {
            app(QueryCollector::class)->collect($query);
        });
    }
}
