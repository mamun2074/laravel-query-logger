<?php

namespace Mahmud2074\QueryLogger\Services;

use Mahmud2074\QueryLogger\Services\QueryFormatter;

class QueryCollector
{
    protected  $queries = [];

    public function collect($query)
    {
        $this->queries[] = [
            'sql'    => QueryFormatter::format($query->sql, $query->bindings),
            'raw'    => $query->sql,
            'time'   => $query->time,
            'file'   => QueryFormatter::caller(),
        ];
    }

    public function all()
    {
        return $this->queries;
    }
}
