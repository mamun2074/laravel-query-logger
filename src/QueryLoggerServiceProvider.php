<?php

namespace Mahmud2074\QueryLogger;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Mahmud2074\QueryLogger\Logger\QueryFileLogger;
use Mahmud2074\QueryLogger\Services\QueryCollector;
use Mahmud2074\QueryLogger\Services\NPlusOneDetector;

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
        ], 'query-logger-config');

        DB::listen(function ($query) {
            app(QueryCollector::class)->collect($query);
        });

        // log queries
        $this->app->terminating(function () {
            $this->logQueries();
        });
    }

    protected function logQueries()
    {
        if (!$this->app->runningInConsole()) {

            if (!env('APP_DEBUG', false)) {
                return;
            }

            if (!config('query-logger.enabled')) {
                return;
            }

            $request = request();
            $queries = app(QueryCollector::class)->all();

            if (!$queries) {
                return;
            }

            $slow = array_filter($queries, function ($q) {
                return $q['time'] >= config('query-logger.slow_query_ms');
            });

            $nPlusOne = NPlusOneDetector::detect(
                $queries,
                config('query-logger.n_plus_one_threshold')
            );

            QueryFileLogger::write([
                'url'           => $request->fullUrl(),
                'method'        => $request->method(),
                'query_count'   => count($queries),
                'total_time'    => array_sum(array_column($queries, 'time')),
                'slow_queries'  => $slow,
                'n_plus_one'    => $nPlusOne,
                'queries'       => $queries,
            ]);
        }
    }
}
