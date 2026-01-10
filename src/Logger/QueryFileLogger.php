<?php

namespace Mahmud2074\QueryLogger\Logger;

use Illuminate\Support\Facades\File;

class QueryFileLogger
{
    public static function write($data)
    {
        $path = config('query-profiler.log_path');

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $file = $path . '/' . date('Y-m-d') . '.log';

        File::append($file, json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL);
    }
}
