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
    "url": "http:\/\/localhost\/api\/public\/api\/v1\/login",
    "method": "POST",
    "query_count": 10,
    "total_time": 66.79,
    "slow_queries": [],
    "n_plus_one": {
        "select * from `oauth_clients` where `id` = ? limit ?": [
            {
                "sql": "select * from `oauth_clients` where `id` = 3 limit 1",
                "raw": "select * from `oauth_clients` where `id` = ? limit 1",
                "time": 0.61,
                "file": "C:\\xampp81\\htdocs\\api\\app\\Http\\Controllers\\API\\v1\\AuthController.php:66"
            },
            {
                "sql": "select * from `oauth_clients` where `id` = 3 limit 1",
                "raw": "select * from `oauth_clients` where `id` = ? limit 1",
                "time": 0.31,
                "file": "C:\\xampp81\\htdocs\\api\\app\\Http\\Controllers\\API\\v1\\AuthController.php:66"
            },
            {
                "sql": "select * from `oauth_clients` where `id` = 3 limit 1",
                "raw": "select * from `oauth_clients` where `id` = ? limit 1",
                "time": 0.84,
                "file": "C:\\xampp81\\htdocs\\api\\app\\Http\\Controllers\\API\\v1\\AuthController.php:66"
            }
        ]
    },
    "queries": [
        {
            "sql": "select * from `users` where `email` = 'mahmud@gmail.com' limit 1",
            "raw": "select * from `users` where `email` = ? limit 1",
            "time": 55.42,
            "file": "C:\\xampp81\\htdocs\\api\\app\\Http\\Controllers\\API\\v1\\AuthController.php:56"
        },
        {
            "sql": "select exists(select * from `oauth_personal_access_clients`) as `exists`",
            "raw": "select exists(select * from `oauth_personal_access_clients`) as `exists`",
            "time": 1.92,
            "file": "C:\\xampp81\\htdocs\\api\\app\\Http\\Controllers\\API\\v1\\AuthController.php:66"
        },
        {
            "sql": "select * from `oauth_personal_access_clients` order by `id` desc limit 1",
            "raw": "select * from `oauth_personal_access_clients` order by `id` desc limit 1",
            "time": 0.35,
            "file": "C:\\xampp81\\htdocs\\api\\app\\Http\\Controllers\\API\\v1\\AuthController.php:66"
        },
        {
            "sql": "select * from `oauth_clients` where `oauth_clients`.`id` = 3 limit 1",
            "raw": "select * from `oauth_clients` where `oauth_clients`.`id` = ? limit 1",
            "time": 2.2,
            "file": "C:\\xampp81\\htdocs\\api\\app\\Http\\Controllers\\API\\v1\\AuthController.php:66"
        },
        {
            "sql": "select * from `oauth_clients` where `id` = 3 limit 1",
            "raw": "select * from `oauth_clients` where `id` = ? limit 1",
            "time": 0.61,
            "file": "C:\\xampp81\\htdocs\\api\\app\\Http\\Controllers\\API\\v1\\AuthController.php:66"
        },
        {
            "sql": "select * from `oauth_clients` where `id` = 3 limit 1",
            "raw": "select * from `oauth_clients` where `id` = ? limit 1",
            "time": 0.31,
            "file": "C:\\xampp81\\htdocs\\api\\app\\Http\\Controllers\\API\\v1\\AuthController.php:66"
        },
        {
            "sql": "update `oauth_access_tokens` set `name` = 'Personal Access Token', `oauth_access_tokens`.`updated_at` = '2026-01-11 17:42:08' where `id` = 'd041ddee1fcf30a408c776ddd0628ba76ddf96682dd3a93fdbe8077f0576ca75fda7ee357df1a42d'",
            "raw": "update `oauth_access_tokens` set `name` = ?, `oauth_access_tokens`.`updated_at` = ? where `id` = ?",
            "time": 1.88,
            "file": "C:\\xampp81\\htdocs\\api\\app\\Http\\Controllers\\API\\v1\\AuthController.php:66"
        }
    ]
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
