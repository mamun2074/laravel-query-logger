<?php
return [
    'enabled' => env('QUERY_LOGGER', false),
    'slow_query_ms' => env('QUERY_SLOW_MS', 100),
    'log_path' => storage_path('logs/query-logger'),
    'n_plus_one_threshold' => 3, // same query repeats
    'n_plus_type' => env('N_PLUS_TYPE', 'raw')  // raw, sql. raw mins same query but value can be differetn. sql mins value and query will same
];
