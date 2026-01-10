<?php


namespace Mahmud2074\QueryProfiler\Services;

class QueryFormatter
{
    public static function format(string $sql, array $bindings): string
    {
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'{$binding}'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        return $sql;
    }

    public static function caller(): string
    {
        foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) as $trace) {
            if (!empty($trace['file']) && str_contains($trace['file'], 'app/')) {
                return $trace['file'] . ':' . $trace['line'];
            }
        }
        return 'unknown';
    }
}
