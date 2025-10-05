### AdvancedDeveloperHelpers

Developer productivity: timing, query tracing, SQL dump, deterministic seeding, and lightweight HTTP mocking.

#### Function Index

- dev_time_callable_ms(callable $fn, int $iterations = 1): array
- dev_trace_queries(callable $fn): array
- dev_sql_dump(string $table, array $where = []): string
- dev_seed_random(int $seed): void
- dev_http_mock(string $url, array $response, int $status = 200): callable


