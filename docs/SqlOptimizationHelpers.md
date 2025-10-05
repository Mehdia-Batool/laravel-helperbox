### SqlOptimizationHelpers

Raw SQL helpers for explain plans, index suggestions, streaming selects, and pagination.

#### Function Index

- sql_explain(string $sql, array $bindings = []): array
- sql_suggest_index(string $table, array $whereFields): array
- sql_stream_select(string $sql, array $bindings, callable $onRow): int
- sql_batch_insert(string $table, array $rows, int $chunk = 1000): int
- sql_auto_paginate_raw(string $sql, array $bindings = [], int $perPage = 15, int $page = null): array


