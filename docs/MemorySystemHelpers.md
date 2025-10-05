### MemorySystemHelpers

Memory, CPU, disk, OS info, and performance snapshots.

#### Function Index

- memory_usage(bool $realUsage = false): int
- memory_usage_human(bool $realUsage = false): string
- memory_peak(bool $realUsage = false): int
- memory_peak_human(bool $realUsage = false): string
- memory_limit(): int
- memory_limit_human(): string
- memory_usage_percentage(bool $realUsage = false): float
- cpu_usage(): float
- system_uptime(): int
- system_uptime_human(): string
- system_loadavg(): array
- system_temp_dir(): string
- system_is_windows(): bool
- system_is_linux(): bool
- system_is_mac(): bool
- system_php_version(): string
- system_php_sapi(): string
- system_disk_usage(string $path): array
- system_disk_usage_human(string $path): array
- system_process_count(): int
- system_memory_info(): array
- system_performance_info(): array
- format_bytes(int $bytes, int $precision = 2): string
- parse_size(string $size): int
- memory_cleanup(): bool
- system_health_check(): array


