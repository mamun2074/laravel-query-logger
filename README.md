# Laravel Query Logger

A lightweight **Laravel query logger package** that logs **route-wise SQL queries**, detects **N+1 problems**, and highlights **slow queries** — without any web UI overhead.

Designed for **local & staging debugging**, not production.

---

## ✨ Features

- Route-wise SQL query logging
- Exact SQL with bindings
- Total query count & execution time
- Slow query detection
- N+1 query detection
- ENV-controlled
- File-based logging (no UI)
- Laravel auto-discovery support

---

## 🚫 What This Package Does NOT Do

- No web UI / dashboard
- No production monitoring
- No query modification
- No framework hacks

---

## 📦 Installation

```bash
composer require mahmud2074/laravel-query-logger --dev
```

---

## ⚙️ Configuration

Publish config file:

```bash
php artisan vendor:publish --tag=config
```

Environment variables:

```env
QUERY_LOGGER=true
QUERY_SLOW_MS=100
N_PLUS_TYPE=raw
```

---

## 🧩 Middleware Setup

Register the middleware in `app/Http/Kernel.php`:

```php
protected $middlewareGroups = [
    'api' => [
        \Mahmud2074\QueryLogger\Middleware\QueryLoggerMiddleware::class,
    ],
];
```

---

## 🧪 Usage

Call any route that executes DB queries:

```
GET /api/v1/users/1
```

Logs will be written to:

```
storage/logs/query-logger/YYYY-MM-DD.log
```

---

## 📄 Sample Log Output

```json
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
```

---

## 🚨 Important Notes

Exact file & line detection is **not reliable** with `DB::listen`.  
This package logs **route + controller action**, which is the correct approach.

---

## 🐘 Supported Versions

- PHP 7.1+
- Laravel 8, 9, 10, 11

---

## 📜 License

MIT License

---

## 👨‍💻 Author

**Md Al-Mahmud**

---

## ⭐ Contributing

Pull requests are welcome.
