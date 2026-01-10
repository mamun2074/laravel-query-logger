<?php
return [
    'enabled' => env('QUERY_PROFILER', false),
    'slow_query_ms' => env('QUERY_SLOW_MS', 100),
    'log_path' => storage_path('logs/query-logger'),
    'n_plus_one_threshold' => 3, // same query repeats
];
