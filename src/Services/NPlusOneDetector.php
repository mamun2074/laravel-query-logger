<?php

namespace Mahmud2074\QueryLogger\Services;

class NPlusOneDetector
{
    public static function detect($queries, $threshold)
    {
        $grouped = [];

        $n_plus_type = config('n_plus_type', 'raw');

        foreach ($queries as $query) {
            $key = preg_replace('/\d+/', '?', $query[$n_plus_type]);
            $grouped[$key][] = $query;
        }

        return array_filter($grouped, function ($items) use ($threshold) {
            return count($items) >= $threshold;
        });
    }
}
