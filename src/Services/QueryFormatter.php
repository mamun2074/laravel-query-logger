<?php


namespace Mahmud2074\QueryLogger\Services;

class QueryFormatter
{
    public static function format($sql, $bindings)
    {
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'{$binding}'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        return $sql;
    }

    public static function caller(): string
    {

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        foreach ($trace as $item) {
            if (
                isset($item['file']) &&
                str_contains($item['file'], base_path('app')) &&
                !str_contains($item['file'], 'vendor')
            ) {
                return $item['file'] . ':' . $item['line'];
            }
        }



        // $ignored = [
        //     'vendor/laravel/framework',
        //     'vendor/mahmud/laravel-query-profiler',
        //     'Illuminate\\',
        // ];

        // foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 20) as $trace) {

        //     if (empty($trace['file'])) {
        //         continue;
        //     }

        //     // Only userland app code
        //     if (str_contains($trace['file'], DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR)) {
        //         return $trace['file'] . ':' . ($trace['line'] ?? '0');
        //     }

        //     // Fallback: repository / domain folders
        //     if (preg_match('#/(Repositories|Services|Models|Controllers)/#', $trace['file'])) {
        //         return $trace['file'] . ':' . ($trace['line'] ?? '0');
        //     }
        // }

        return 'framework/vendor';
    }
}
