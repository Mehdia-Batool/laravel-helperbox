<?php

/**
 * SQL Optimization & Data Utilities
 *
 * Explain/Analyze helpers, index suggestions (basic heuristics), auto pagination,
 * batch insert/update, stream large selects, and result caching wrappers.
 *
 * @package Subhashladumor\LaravelHelperbox
 */

use Illuminate\Support\Facades\DB;

if (!function_exists('sql_explain')) {
    function sql_explain(string $sql, array $bindings = []): array
    {
        return DB::select('EXPLAIN ' . $sql, $bindings);
    }
}

if (!function_exists('sql_suggest_index')) {
    function sql_suggest_index(string $table, array $whereFields): array
    {
        // Simple suggestion: composite index in given field order
        $indexName = 'idx_' . $table . '_' . implode('_', $whereFields);
        $ddl = 'ALTER TABLE ' . $table . ' ADD INDEX ' . $indexName . ' (' . implode(',', $whereFields) . ')';
        return ['index' => $indexName, 'ddl' => $ddl];
    }
}

if (!function_exists('sql_stream_select')) {
    function sql_stream_select(string $sql, array $bindings, callable $onRow): int
    {
        $count = 0;
        $stmt = DB::getPdo()->prepare($sql);
        $stmt->execute($bindings);
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) { $onRow($row); $count++; }
        return $count;
    }
}

if (!function_exists('sql_batch_insert')) {
    function sql_batch_insert(string $table, array $rows, int $chunk = 1000): int
    {
        $inserted = 0; foreach (array_chunk($rows, $chunk) as $part) { DB::table($table)->insert($part); $inserted += count($part); }
        return $inserted;
    }
}

if (!function_exists('sql_auto_paginate_raw')) {
    function sql_auto_paginate_raw(string $sql, array $bindings = [], int $perPage = 15, int $page = null): array
    {
        $page = $page ?? max(1, (int) request('page', 1));
        $offset = ($page - 1) * $perPage;
        $paged = $sql . ' LIMIT ' . (int) $perPage . ' OFFSET ' . (int) $offset;
        $data = DB::select($paged, $bindings);
        return ['data' => $data, 'page' => $page, 'per_page' => $perPage];
    }
}

?>


