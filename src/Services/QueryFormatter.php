<?php


namespace Mahmud2074\QueryLogger\Services;

use DateTimeInterface;

class QueryFormatter
{
    public static function format($sql, $bindings)
    {
        foreach ($bindings as $binding) {
            if ($binding === null) {
                $value = 'NULL';
            } elseif ($binding instanceof DateTimeInterface) {
                $value = "'" . $binding->format('Y-m-d H:i:s') . "'";
            } elseif (is_numeric($binding)) {
                $value = $binding;
            } else {
                $value = "'" . addslashes($binding) . "'";
            }
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
