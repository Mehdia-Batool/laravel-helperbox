<?php

/**
 * Advanced Cache Helper Functions
 *
 * Helpers for stampede prevention, tagged/versioned keys, randomized TTL,
 * chunked data, compression, diff-updates, locks, and rate limiting.
 * All functions use function_exists guards and are callable directly.
 *
 * @package Subhashladumor\LaravelHelperbox
 */

use Illuminate\Support\Facades\Cache;

if (!function_exists('cache_with_jitter')) {
    function cache_with_jitter(string $key, int $baseTtl, int $jitterPercent = 10, callable $producer = null)
    {
        $ttl = max(1, (int) round($baseTtl * (1 + (random_int(-$jitterPercent, $jitterPercent) / 100))));
        if ($producer) {
            return Cache::remember($key, $ttl, $producer);
        }
        return [$key, $ttl];
    }
}

if (!function_exists('cache_versioned_key')) {
    function cache_versioned_key(string $baseKey, string|int $version): string
    {
        return $baseKey . ':v' . $version;
    }
}

if (!function_exists('cache_remember_tagged')) {
    function cache_remember_tagged(array|string $tags, string $key, int $ttl, callable $producer)
    {
        $repo = Cache::tags((array) $tags);
        return $repo->remember($key, $ttl, $producer);
    }
}

if (!function_exists('cache_invalidate_tags')) {
    function cache_invalidate_tags(array|string $tags): void
    {
        Cache::tags((array) $tags)->flush();
    }
}

if (!function_exists('cache_chunked_set')) {
    function cache_chunked_set(string $keyPrefix, string $payload, int $chunkSize = 900000, int $ttl = 3600): int
    {
        $len = strlen($payload);
        $chunks = (int) ceil($len / $chunkSize);
        Cache::put($keyPrefix . ':chunks', $chunks, $ttl);
        for ($i = 0; $i < $chunks; $i++) {
            $part = substr($payload, $i * $chunkSize, $chunkSize);
            Cache::put($keyPrefix . ':' . $i, $part, $ttl);
        }
        return $chunks;
    }
}

if (!function_exists('cache_chunked_get')) {
    function cache_chunked_get(string $keyPrefix): ?string
    {
        $chunks = Cache::get($keyPrefix . ':chunks');
        if (!$chunks) return null;
        $buf = '';
        for ($i = 0; $i < $chunks; $i++) {
            $part = Cache::get($keyPrefix . ':' . $i);
            if ($part === null) return null;
            $buf .= $part;
        }
        return $buf;
    }
}

if (!function_exists('cache_randomized_ttl')) {
    function cache_randomized_ttl(int $ttl, int $spread = 20): int
    {
        return max(1, (int) round($ttl * (1 + (random_int(-$spread, $spread) / 100))));
    }
}

if (!function_exists('cache_precompute')) {
    function cache_precompute(string $key, int $ttl, callable $producer)
    {
        $value = $producer();
        Cache::put($key, $value, $ttl);
        return $value;
    }
}

if (!function_exists('cache_invalidate_model')) {
    function cache_invalidate_model(string $modelClass, string|int $id): void
    {
        Cache::forget("model:{$modelClass}:{$id}");
    }
}

if (!function_exists('cache_json_response')) {
    function cache_json_response(string $key, int $ttl, callable $producer): array
    {
        return Cache::remember($key, $ttl, function () use ($producer) {
            $data = $producer();
            return is_array($data) ? $data : (array) $data;
        });
    }
}

if (!function_exists('cache_lock_run')) {
    function cache_lock_run(string $name, int $seconds, callable $callback)
    {
        $lock = Cache::lock($name, $seconds);
        try {
            return $lock->block($seconds, $callback);
        } finally {
            optional($lock)->release();
        }
    }
}

if (!function_exists('rate_limit_check')) {
    function rate_limit_check(string $key, int $maxAttempts, int $decaySeconds): bool
    {
        $bucket = "rate:{$key}";
        $attempts = (int) Cache::get($bucket, 0);
        if ($attempts >= $maxAttempts) return false;
        Cache::put($bucket, $attempts + 1, $decaySeconds);
        return true;
    }
}

if (!function_exists('cache_diff_update')) {
    function cache_diff_update(string $key, array $newData, int $ttl = 3600): array
    {
        $old = (array) Cache::get($key, []);
        $diff = array_diff_assoc($newData, $old);
        if ($diff) Cache::put($key, array_replace($old, $diff), $ttl);
        return $diff;
    }
}

if (!function_exists('cache_compress_set')) {
    function cache_compress_set(string $key, mixed $value, int $ttl = 3600): void
    {
        $payload = gzdeflate(serialize($value), 6);
        Cache::put($key, $payload, $ttl);
    }
}

if (!function_exists('cache_compress_get')) {
    function cache_compress_get(string $key, mixed $default = null): mixed
    {
        $payload = Cache::get($key);
        if ($payload === null) return $default;
        return unserialize(gzinflate($payload));
    }
}

if (!function_exists('cache_stampeded_guard')) {
    function cache_stampeded_guard(string $key, int $ttl, callable $producer)
    {
        $guardKey = "guard:{$key}";
        $value = Cache::get($key);
        if ($value !== null) return $value;
        return cache_lock_run($guardKey, 5, function () use ($key, $ttl, $producer) {
            $existing = Cache::get($key);
            if ($existing !== null) return $existing;
            $v = $producer();
            Cache::put($key, $v, $ttl);
            return $v;
        });
    }
}

if (!function_exists('cache_forget_by_prefix')) {
    function cache_forget_by_prefix(string $prefix): int
    {
        // Works only for stores supporting listing; otherwise, rely on tags.
        if (method_exists(Cache::getStore(), 'getPrefix') && method_exists(Cache::getStore(), 'many')) {
            // Not universally supported; encourage using tags in docs.
        }
        return 0;
    }
}

?>


