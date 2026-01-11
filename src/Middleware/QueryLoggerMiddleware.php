<?php


namespace Mahmud2074\QueryLogger\Middleware;

use Closure;
use Mahmud2074\QueryLogger\Services\QueryCollector;
use Mahmud2074\QueryLogger\Services\NPlusOneDetector;
use Mahmud2074\QueryLogger\Logger\QueryFileLogger;

class QueryLoggerMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (!env('APP_DEBUG', false)) {
            return $response;
        }

        if (!config('query-logger.enabled')) {
            return $response;
        }

        $queries = app(QueryCollector::class)->all();

        if (!$queries) {
            return $response;
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

        return $response;
    }
}
