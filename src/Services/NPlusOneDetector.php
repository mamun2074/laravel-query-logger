<?php

namespace Mahmud2074\QueryLogger\Services;

class NPlusOneDetector
{
    public static function detect($queries, $threshold)
    {
        $grouped = [];

        foreach ($queries as $query) {
            $key = preg_replace('/\d+/', '?', $query['raw']);
            $grouped[$key][] = $query;
        }

        return array_filter($grouped, function ($items) use ($threshold) {
            return count($items) >= $threshold;
        });
    }
}
