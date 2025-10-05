<?php

/**
 * Memory & System Helper Functions
 * 
 * This file contains 20+ advanced system monitoring and memory utility functions
 * for performance tracking, system information, and resource management.
 * 
 * @package Subhashladumor\LaravelHelperbox
 * @author Subhash Ladumor
 */

if (!function_exists('memory_usage')) {
    /**
     * Get current memory usage
     * 
     * @param bool $realUsage Whether to get real memory usage
     * @return int Memory usage in bytes
     */
    function memory_usage(bool $realUsage = false): int
    {
        return memory_get_usage($realUsage);
    }
}

if (!function_exists('memory_usage_human')) {
    /**
     * Get current memory usage in human-readable format
     * 
     * @param bool $realUsage Whether to get real memory usage
     * @return string Human-readable memory usage
     */
    function memory_usage_human(bool $realUsage = false): string
    {
        $bytes = memory_usage($realUsage);
        return format_bytes($bytes);
    }
}

if (!function_exists('memory_peak')) {
    /**
     * Get peak memory usage
     * 
     * @param bool $realUsage Whether to get real memory usage
     * @return int Peak memory usage in bytes
     */
    function memory_peak(bool $realUsage = false): int
    {
        return memory_get_peak_usage($realUsage);
    }
}

if (!function_exists('memory_peak_human')) {
    /**
     * Get peak memory usage in human-readable format
     * 
     * @param bool $realUsage Whether to get real memory usage
     * @return string Human-readable peak memory usage
     */
    function memory_peak_human(bool $realUsage = false): string
    {
        $bytes = memory_peak($realUsage);
        return format_bytes($bytes);
    }
}

if (!function_exists('memory_limit')) {
    /**
     * Get current PHP memory limit
     * 
     * @return int Memory limit in bytes
     */
    function memory_limit(): int
    {
        $limit = ini_get('memory_limit');
        return parse_size($limit);
    }
}

if (!function_exists('memory_limit_human')) {
    /**
     * Get current PHP memory limit in human-readable format
     * 
     * @return string Human-readable memory limit
     */
    function memory_limit_human(): string
    {
        $bytes = memory_limit();
        return format_bytes($bytes);
    }
}

if (!function_exists('memory_usage_percentage')) {
    /**
     * Get memory usage as percentage of limit
     * 
     * @param bool $realUsage Whether to use real memory usage
     * @return float Memory usage percentage
     */
    function memory_usage_percentage(bool $realUsage = false): float
    {
        $current = memory_usage($realUsage);
        $limit = memory_limit();
        
        if ($limit <= 0) {
            return 0;
        }
        
        return ($current / $limit) * 100;
    }
}

if (!function_exists('cpu_usage')) {
    /**
     * Get CPU usage percentage
     * 
     * @return float CPU usage percentage
     */
    function cpu_usage(): float
    {
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            return $load[0] * 100; // 1-minute load average as percentage
        }
        
        return 0;
    }
}

if (!function_exists('system_uptime')) {
    /**
     * Get system uptime
     * 
     * @return int System uptime in seconds
     */
    function system_uptime(): int
    {
        if (file_exists('/proc/uptime')) {
            $uptime = file_get_contents('/proc/uptime');
            return (int) explode(' ', $uptime)[0];
        }
        
        return 0;
    }
}

if (!function_exists('system_uptime_human')) {
    /**
     * Get system uptime in human-readable format
     * 
     * @return string Human-readable uptime
     */
    function system_uptime_human(): string
    {
        $seconds = system_uptime();
        
        if ($seconds === 0) {
            return 'Unknown';
        }
        
        $days = floor($seconds / 86400);
        $hours = floor(($seconds % 86400) / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        
        $result = [];
        
        if ($days > 0) {
            $result[] = $days . ' day' . ($days > 1 ? 's' : '');
        }
        
        if ($hours > 0) {
            $result[] = $hours . ' hour' . ($hours > 1 ? 's' : '');
        }
        
        if ($minutes > 0) {
            $result[] = $minutes . ' minute' . ($minutes > 1 ? 's' : '');
        }
        
        return implode(', ', $result);
    }
}

if (!function_exists('system_loadavg')) {
    /**
     * Get system load average
     * 
     * @return array Load average for 1, 5, and 15 minutes
     */
    function system_loadavg(): array
    {
        if (function_exists('sys_getloadavg')) {
            return sys_getloadavg();
        }
        
        return [0, 0, 0];
    }
}

if (!function_exists('system_temp_dir')) {
    /**
     * Get system temporary directory
     * 
     * @return string Temporary directory path
     */
    function system_temp_dir(): string
    {
        return sys_get_temp_dir();
    }
}

if (!function_exists('system_is_windows')) {
    /**
     * Check if operating system is Windows
     * 
     * @return bool True if Windows
     */
    function system_is_windows(): bool
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }
}

if (!function_exists('system_is_linux')) {
    /**
     * Check if operating system is Linux
     * 
     * @return bool True if Linux
     */
    function system_is_linux(): bool
    {
        return strtoupper(substr(PHP_OS, 0, 5)) === 'LINUX';
    }
}

if (!function_exists('system_is_mac')) {
    /**
     * Check if operating system is macOS
     * 
     * @return bool True if macOS
     */
    function system_is_mac(): bool
    {
        return strtoupper(substr(PHP_OS, 0, 6)) === 'DARWIN';
    }
}

if (!function_exists('system_php_version')) {
    /**
     * Get PHP version
     * 
     * @return string PHP version
     */
    function system_php_version(): string
    {
        return PHP_VERSION;
    }
}

if (!function_exists('system_php_sapi')) {
    /**
     * Get PHP SAPI (Server API)
     * 
     * @return string PHP SAPI
     */
    function system_php_sapi(): string
    {
        return php_sapi_name();
    }
}

if (!function_exists('system_disk_usage')) {
    /**
     * Get disk usage for a path
     * 
     * @param string $path Path to check
     * @return array Disk usage information
     */
    function system_disk_usage(string $path): array
    {
        if (!is_dir($path)) {
            return [
                'total' => 0,
                'free' => 0,
                'used' => 0,
                'percentage' => 0
            ];
        }
        
        $total = disk_total_space($path);
        $free = disk_free_space($path);
        $used = $total - $free;
        $percentage = $total > 0 ? ($used / $total) * 100 : 0;
        
        return [
            'total' => $total,
            'free' => $free,
            'used' => $used,
            'percentage' => round($percentage, 2)
        ];
    }
}

if (!function_exists('system_disk_usage_human')) {
    /**
     * Get disk usage in human-readable format
     * 
     * @param string $path Path to check
     * @return array Human-readable disk usage
     */
    function system_disk_usage_human(string $path): array
    {
        $usage = system_disk_usage($path);
        
        return [
            'total' => format_bytes($usage['total']),
            'free' => format_bytes($usage['free']),
            'used' => format_bytes($usage['used']),
            'percentage' => $usage['percentage'] . '%'
        ];
    }
}

if (!function_exists('system_process_count')) {
    /**
     * Get number of running processes
     * 
     * @return int Number of processes
     */
    function system_process_count(): int
    {
        if (function_exists('shell_exec')) {
            $output = shell_exec('ps aux | wc -l');
            return (int) trim($output) - 1; // Subtract 1 for header
        }
        
        return 0;
    }
}

if (!function_exists('system_memory_info')) {
    /**
     * Get detailed memory information
     * 
     * @return array Memory information
     */
    function system_memory_info(): array
    {
        return [
            'current' => memory_usage(),
            'current_human' => memory_usage_human(),
            'peak' => memory_peak(),
            'peak_human' => memory_peak_human(),
            'limit' => memory_limit(),
            'limit_human' => memory_limit_human(),
            'usage_percentage' => memory_usage_percentage(),
            'real_usage' => memory_usage(true),
            'real_peak' => memory_peak(true)
        ];
    }
}

if (!function_exists('system_performance_info')) {
    /**
     * Get comprehensive performance information
     * 
     * @return array Performance information
     */
    function system_performance_info(): array
    {
        return [
            'memory' => system_memory_info(),
            'cpu_usage' => cpu_usage(),
            'load_average' => system_loadavg(),
            'uptime' => system_uptime(),
            'uptime_human' => system_uptime_human(),
            'php_version' => system_php_version(),
            'php_sapi' => system_php_sapi(),
            'os' => PHP_OS,
            'is_windows' => system_is_windows(),
            'is_linux' => system_is_linux(),
            'is_mac' => system_is_mac()
        ];
    }
}

if (!function_exists('format_bytes')) {
    /**
     * Format bytes to human-readable format
     * 
     * @param int $bytes Number of bytes
     * @param int $precision Number of decimal places
     * @return string Formatted string
     */
    function format_bytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}

if (!function_exists('parse_size')) {
    /**
     * Parse size string to bytes
     * 
     * @param string $size Size string (e.g., '128M', '1G')
     * @return int Size in bytes
     */
    function parse_size(string $size): int
    {
        $size = trim($size);
        $last = strtolower($size[strlen($size) - 1]);
        $size = (int) $size;
        
        switch ($last) {
            case 'g':
                $size *= 1024;
            case 'm':
                $size *= 1024;
            case 'k':
                $size *= 1024;
        }
        
        return $size;
    }
}

if (!function_exists('memory_cleanup')) {
    /**
     * Force garbage collection and memory cleanup
     * 
     * @return bool True if successful
     */
    function memory_cleanup(): bool
    {
        if (function_exists('gc_collect_cycles')) {
            gc_collect_cycles();
        }
        
        return true;
    }
}

if (!function_exists('system_health_check')) {
    /**
     * Perform basic system health check
     * 
     * @return array Health check results
     */
    function system_health_check(): array
    {
        $memoryUsage = memory_usage_percentage();
        $loadAverage = system_loadavg();
        $diskUsage = system_disk_usage('/');
        
        return [
            'memory_ok' => $memoryUsage < 80,
            'memory_usage' => $memoryUsage,
            'cpu_ok' => $loadAverage[0] < 2.0,
            'cpu_load' => $loadAverage[0],
            'disk_ok' => $diskUsage['percentage'] < 90,
            'disk_usage' => $diskUsage['percentage'],
            'overall_ok' => $memoryUsage < 80 && $loadAverage[0] < 2.0 && $diskUsage['percentage'] < 90
        ];
    }
}
