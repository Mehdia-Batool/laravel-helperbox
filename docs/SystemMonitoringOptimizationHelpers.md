### SystemMonitoringOptimizationHelpers

Linux-oriented monitoring helpers for CPU, disk, network, processes, health report, latency timing, and simple rate counters.

#### Function Index

- system_cpu_usage_percent(): float|null
- system_disk_usage(string $path = '/'): array
- system_network_bytes(): array|null
- system_process_count(): int|null
- system_health_report(): array
- latency_timer(callable $fn): array
- simple_rate_counter(string $key, int $windowSeconds = 60): array


