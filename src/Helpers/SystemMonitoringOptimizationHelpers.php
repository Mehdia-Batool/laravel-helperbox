<?php

/**
 * System Monitoring & Optimization Helpers
 *
 * Memory/CPU/disk/network usage, process info, uptime, health reports,
 * simple rate/latency trackers, and cron/queue health.
 *
 * @package Subhashladumor\LaravelHelperbox
 */

if (!function_exists('system_cpu_usage_percent')) {
    function system_cpu_usage_percent(): float|null
    {
        if (strncasecmp(PHP_OS, 'WIN', 3) === 0) return null;
        $stat1 = @file_get_contents('/proc/stat');
        usleep(100000);
        $stat2 = @file_get_contents('/proc/stat');
        if (!$stat1 || !$stat2) return null;
        $cpu1 = preg_split('/\s+/', trim(explode("\n", $stat1)[0]));
        $cpu2 = preg_split('/\s+/', trim(explode("\n", $stat2)[0]));
        $idle1 = (int) $cpu1[4]; $idle2 = (int) $cpu2[4];
        $total1 = array_sum(array_map('intval', array_slice($cpu1, 1)));
        $total2 = array_sum(array_map('intval', array_slice($cpu2, 1)));
        $diffIdle = $idle2 - $idle1; $diffTotal = $total2 - $total1;
        return $diffTotal > 0 ? (1 - ($diffIdle / $diffTotal)) * 100.0 : null;
    }
}

if (!function_exists('system_disk_usage')) {
    function system_disk_usage(string $path = '/'): array
    {
        $total = @disk_total_space($path) ?: 0; $free = @disk_free_space($path) ?: 0;
        $used = max(0, $total - $free);
        return ['total' => $total, 'free' => $free, 'used' => $used, 'used_percent' => $total ? ($used / $total) * 100 : 0];
    }
}

if (!function_exists('system_network_bytes')) {
    function system_network_bytes(): array|null
    {
        if (!is_readable('/proc/net/dev')) return null;
        $lines = file('/proc/net/dev');
        $rx = 0; $tx = 0;
        foreach ($lines as $i => $line) {
            if ($i < 2) continue;
            [$iface, $rest] = array_map('trim', explode(':', trim($line)));
            $parts = preg_split('/\s+/', $rest);
            $rx += (int) $parts[0];
            $tx += (int) $parts[8];
        }
        return ['rx' => $rx, 'tx' => $tx];
    }
}

if (!function_exists('system_process_count')) {
    function system_process_count(): int|null
    {
        if (!is_dir('/proc')) return null;
        $count = 0; $dh = opendir('/proc');
        if (!$dh) return null;
        while (($entry = readdir($dh)) !== false) { if (ctype_digit($entry)) $count++; }
        closedir($dh);
        return $count;
    }
}

if (!function_exists('system_health_report')) {
    function system_health_report(): array
    {
        $cpu = system_cpu_usage_percent();
        $disk = system_disk_usage(PHP_OS_FAMILY === 'Windows' ? getcwd() : '/');
        $memUsage = memory_get_usage(true); $memPeak = memory_get_peak_usage(true);
        return [
            'cpu_percent' => $cpu,
            'disk' => $disk,
            'memory_bytes' => $memUsage,
            'memory_peak_bytes' => $memPeak,
            'overall_ok' => ($cpu === null || $cpu < 90) && ($disk['used_percent'] < 95)
        ];
    }
}

if (!function_exists('latency_timer')) {
    function latency_timer(callable $fn): array
    {
        $start = microtime(true); $result = $fn(); $ms = (microtime(true) - $start) * 1000;
        return ['ms' => $ms, 'result' => $result];
    }
}

if (!function_exists('simple_rate_counter')) {
    function simple_rate_counter(string $key, int $windowSeconds = 60): array
    {
        $now = time(); $bucket = intdiv($now, $windowSeconds);
        $cacheKey = "ratebucket:{$key}:{$bucket}";
        $count = (int) cache()->increment($cacheKey);
        cache()->put($cacheKey, $count, $windowSeconds);
        return ['bucket' => $bucket, 'count' => $count, 'window' => $windowSeconds];
    }
}

?>


