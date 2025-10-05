<?php

/**
 * Advanced Developer Utilities
 *
 * Query/request timers, event tracing, SQL dump helpers, simple HTTP/model
 * mocking stubs, and deterministic random seeding for tests.
 *
 * @package Subhashladumor\LaravelHelperbox
 */

use Illuminate\Support\Facades\DB;

if (!function_exists('dev_time_callable_ms')) {
    function dev_time_callable_ms(callable $fn, int $iterations = 1): array
    {
        $total = 0; $result = null;
        for ($i = 0; $i < $iterations; $i++) {
            $start = microtime(true);
            $result = $fn($i);
            $total += (microtime(true) - $start) * 1000;
        }
        return ['ms_total' => $total, 'ms_avg' => $total / max(1, $iterations), 'result' => $result];
    }
}

if (!function_exists('dev_trace_queries')) {
    function dev_trace_queries(callable $fn): array
    {
        DB::enableQueryLog();
        try { $fn(); return DB::getQueryLog(); }
        finally { DB::disableQueryLog(); }
    }
}

if (!function_exists('dev_sql_dump')) {
    function dev_sql_dump(string $table, array $where = []): string
    {
        $builder = DB::table($table);
        foreach ($where as $k => $v) $builder->where($k, $v);
        return $builder->toSql();
    }
}

if (!function_exists('dev_seed_random')) {
    function dev_seed_random(int $seed): void
    {
        mt_srand($seed);
        srand($seed);
    }
}

if (!function_exists('dev_http_mock')) {
    function dev_http_mock(string $url, array $response, int $status = 200): callable
    {
        return function ($method, $calledUrl) use ($url, $response, $status) {
            if ($calledUrl === $url) {
                return ['status' => $status, 'json' => $response];
            }
            return ['status' => 404, 'json' => ['error' => 'Not mocked']];
        };
    }
}

?>


