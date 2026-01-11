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

    public static function caller()
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
        
        return 'framework/vendor';
    }
}
