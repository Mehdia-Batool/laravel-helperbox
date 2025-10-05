### CacheSessionHelpers

Cache shortcuts and ergonomic session helpers for flash messages, multi-get/put, and pattern/tag-based operations.

#### Function Index

- cache_has_or_store(string $key, callable $callback, int $seconds = 3600)
- cache_forget_if_exists(string $key): bool
- cache_increment(string $key, int $value = 1): int
- cache_decrement(string $key, int $value = 1): int
- cache_forever_if_not_exists(string $key, callable $callback)
- session_flash_success(string $message): void
- session_flash_error(string $message): void
- session_flash_warning(string $message): void
- session_flash_info(string $message): void
- session_is_expired(): bool
- session_id_regenerate(): bool
- session_put_multiple(array $data): void
- session_get_multiple(array $keys, mixed $default = null): array
- session_forget_multiple(array $keys): void
- session_has_any(array $keys): bool
- session_has_all(array $keys): bool
- session_flush_except(array $keys): void
- cache_remember_or_fail(string $key, int $seconds, callable $callback)
- cache_remember_or_default(string $key, int $seconds, callable $callback, mixed $default = null)
- cache_remember_forever_or_fail(string $key, callable $callback)
- cache_remember_forever_or_default(string $key, callable $callback, mixed $default = null)
- cache_flush_by_pattern(string $pattern): int
- cache_get_or_put(string $key, mixed $value, int $seconds = 3600)
- cache_get_or_put_forever(string $key, mixed $value)
- session_get_or_put(string $key, mixed $value)
- session_get_or_put_multiple(array $data): array
- cache_has_and_not_expired(string $key): bool
- cache_get_ttl(string $key): ?int
- session_cleanup_expired(): int
- cache_remember_with_tags(array $tags, string $key, int $seconds, callable $callback)
- cache_flush_by_tags(array $tags): bool
- session_merge(string $key, array $data): void
- session_push(string $key, mixed $value): void
- session_pop(string $key)


