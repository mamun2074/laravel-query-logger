Laravel Query Profiler

A lightweight Laravel query profiling package that logs route-wise SQL queries, detects N+1 problems, and highlights slow queries — all without any web UI overhead.

Designed for local & staging debugging, not production.

✨ Features

✅ Route-wise SQL query logging

✅ Exact SQL with bindings

✅ Total query count & execution time

✅ Slow query detection

✅ N+1 query detection

✅ ENV-controlled

✅ File-based logging (no UI, no JS)

✅ Laravel auto-discovery support

🚫 What This Package Does NOT Do

❌ No web UI / dashboard

❌ No production monitoring

❌ No query modification

❌ No framework hacks

📦 Installation
1️⃣ Install via Composer
composer require mahmud/laravel-query-profiler --dev


⚠️ Recommended only for local or staging environments.

⚙️ Configuration
Publish config file
php artisan vendor:publish --tag=config


This will create:

config/query-profiler.php

Environment variables
QUERY_PROFILER=true
QUERY_SLOW_MS=100

Config options (config/query-profiler.php)
return [
    'enabled' => env('QUERY_PROFILER', false),

    // Mark queries slower than this (ms)
    'slow_query_ms' => env('QUERY_SLOW_MS', 100),

    // Log directory
    'log_path' => storage_path('logs/query-profiler'),

    // Same query repeated X times = N+1
    'n_plus_one_threshold' => 3,
];

🧩 Middleware Setup

Register the middleware in app/Http/Kernel.php:

protected $middlewareGroups = [
    'api' => [
        \Mahmud\QueryProfiler\Middleware\QueryProfilerMiddleware::class,
    ],
];


You may also register it in the web group if needed.

🧪 Usage

Call any route that executes database queries:

GET /api/v1/users/1


Logs will be written to:

storage/logs/query-profiler/YYYY-MM-DD.log

📄 Sample Log Output
{
  "method": "GET",
  "path": "/api/v1/users/1",
  "action": "App\\Http\\Controllers\\UserController@show",
  "query_count": 6,
  "total_time": 84,
  "slow_queries": [
    {
      "sql": "SELECT * FROM orders WHERE user_id = 1",
      "time": 140
    }
  ],
  "n_plus_one": {
    "SELECT * FROM posts WHERE user_id = ?": [
      "... repeated 5 times ..."
    ]
  }
}

🚨 Important Notes
❗ File & Line Detection

Due to Laravel’s internal query execution flow, exact file/line detection is not reliable when using DB::listen.
Instead, this package logs:

Route path

HTTP method

Controller & action

This is the correct and professional approach.

❗ Production Usage

DO NOT enable in production

APP_ENV=local
QUERY_PROFILER=true

🧠 How N+1 Detection Works

Normalizes SQL queries

Groups repeated queries

Flags them when repetition exceeds configured threshold

🐘 Supported Versions

PHP 7.1+

Laravel 8, 9, 10, 11

📜 License

MIT License

👨‍💻 Author

Md Al-Mahmud
Senior Software Engineer

⭐ Contributing

Pull requests are welcome.
Issues and feature requests are appreciated.

🚀 Roadmap (Optional)

 Artisan command to analyze logs

 Text-based log formatter

 Per-route enable/disable