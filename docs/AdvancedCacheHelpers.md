### AdvancedCacheHelpers

Advanced caching patterns: stampede prevention, jittered TTLs, tagging, chunked payloads, compression, locks, rate limiting.

#### Function Index

- cache_with_jitter(string $key, int $baseTtl, int $jitterPercent = 10, callable $producer = null)
- cache_versioned_key(string $baseKey, string|int $version): string
- cache_remember_tagged(array|string $tags, string $key, int $ttl, callable $producer)
- cache_invalidate_tags(array|string $tags): void
- cache_chunked_set(string $keyPrefix, string $payload, int $chunkSize = 900000, int $ttl = 3600): int
- cache_chunked_get(string $keyPrefix): ?string
- cache_randomized_ttl(int $ttl, int $spread = 20): int
- cache_precompute(string $key, int $ttl, callable $producer)
- cache_invalidate_model(string $modelClass, string|int $id): void
- cache_json_response(string $key, int $ttl, callable $producer): array
- cache_lock_run(string $name, int $seconds, callable $callback)
- rate_limit_check(string $key, int $maxAttempts, int $decaySeconds): bool
- cache_diff_update(string $key, array $newData, int $ttl = 3600): array
- cache_compress_set(string $key, mixed $value, int $ttl = 3600): void
- cache_compress_get(string $key, mixed $default = null): mixed
- cache_stampeded_guard(string $key, int $ttl, callable $producer)
- cache_forget_by_prefix(string $prefix): int


