<?php

/**
 * Cache & Session Helper Functions
 * 
 * This file contains 20+ advanced caching and session utility functions
 * for cache management, session handling, and data persistence.
 * 
 * @package Subhashladumor\LaravelHelperbox
 * @author Subhash Ladumor
 */

if (!function_exists('cache_has_or_store')) {
    /**
     * Store value in cache if key doesn't exist
     * 
     * @param string $key Cache key
     * @param callable $callback Callback to generate value
     * @param int $seconds TTL in seconds
     * @return mixed Cached value
     */
    function cache_has_or_store(string $key, callable $callback, int $seconds = 3600)
    {
        if (Cache::has($key)) {
            return Cache::get($key);
        }
        
        $value = $callback();
        Cache::put($key, $value, $seconds);
        
        return $value;
    }
}

if (!function_exists('cache_forget_if_exists')) {
    /**
     * Forget cache key if it exists
     * 
     * @param string $key Cache key
     * @return bool True if forgotten
     */
    function cache_forget_if_exists(string $key): bool
    {
        if (Cache::has($key)) {
            return Cache::forget($key);
        }
        
        return true;
    }
}

if (!function_exists('cache_increment')) {
    /**
     * Increment cache value
     * 
     * @param string $key Cache key
     * @param int $value Value to increment by
     * @return int New value
     */
    function cache_increment(string $key, int $value = 1): int
    {
        if (Cache::has($key)) {
            $current = Cache::get($key, 0);
            $newValue = $current + $value;
            Cache::put($key, $newValue);
            return $newValue;
        }
        
        Cache::put($key, $value);
        return $value;
    }
}

if (!function_exists('cache_decrement')) {
    /**
     * Decrement cache value
     * 
     * @param string $key Cache key
     * @param int $value Value to decrement by
     * @return int New value
     */
    function cache_decrement(string $key, int $value = 1): int
    {
        if (Cache::has($key)) {
            $current = Cache::get($key, 0);
            $newValue = max(0, $current - $value);
            Cache::put($key, $newValue);
            return $newValue;
        }
        
        Cache::put($key, 0);
        return 0;
    }
}

if (!function_exists('cache_forever_if_not_exists')) {
    /**
     * Store value in cache forever if key doesn't exist
     * 
     * @param string $key Cache key
     * @param callable $callback Callback to generate value
     * @return mixed Cached value
     */
    function cache_forever_if_not_exists(string $key, callable $callback)
    {
        if (Cache::has($key)) {
            return Cache::get($key);
        }
        
        $value = $callback();
        Cache::forever($key, $value);
        
        return $value;
    }
}

if (!function_exists('session_flash_success')) {
    /**
     * Flash success message to session
     * 
     * @param string $message Success message
     * @return void
     */
    function session_flash_success(string $message): void
    {
        session()->flash('success', $message);
    }
}

if (!function_exists('session_flash_error')) {
    /**
     * Flash error message to session
     * 
     * @param string $message Error message
     * @return void
     */
    function session_flash_error(string $message): void
    {
        session()->flash('error', $message);
    }
}

if (!function_exists('session_flash_warning')) {
    /**
     * Flash warning message to session
     * 
     * @param string $message Warning message
     * @return void
     */
    function session_flash_warning(string $message): void
    {
        session()->flash('warning', $message);
    }
}

if (!function_exists('session_flash_info')) {
    /**
     * Flash info message to session
     * 
     * @param string $message Info message
     * @return void
     */
    function session_flash_info(string $message): void
    {
        session()->flash('info', $message);
    }
}

if (!function_exists('session_is_expired')) {
    /**
     * Check if session is expired
     * 
     * @return bool True if expired
     */
    function session_is_expired(): bool
    {
        $lifetime = config('session.lifetime', 120);
        $lastActivity = session('_last_activity', time());
        
        return (time() - $lastActivity) > ($lifetime * 60);
    }
}

if (!function_exists('session_id_regenerate')) {
    /**
     * Regenerate session ID
     * 
     * @return bool True if successful
     */
    function session_id_regenerate(): bool
    {
        return session()->regenerate();
    }
}

if (!function_exists('session_put_multiple')) {
    /**
     * Put multiple values in session
     * 
     * @param array $data Key-value pairs
     * @return void
     */
    function session_put_multiple(array $data): void
    {
        foreach ($data as $key => $value) {
            session([$key => $value]);
        }
    }
}

if (!function_exists('session_get_multiple')) {
    /**
     * Get multiple values from session
     * 
     * @param array $keys Array of keys
     * @param mixed $default Default value
     * @return array Key-value pairs
     */
    function session_get_multiple(array $keys, $default = null): array
    {
        $result = [];
        
        foreach ($keys as $key) {
            $result[$key] = session($key, $default);
        }
        
        return $result;
    }
}

if (!function_exists('session_forget_multiple')) {
    /**
     * Forget multiple session keys
     * 
     * @param array $keys Array of keys
     * @return void
     */
    function session_forget_multiple(array $keys): void
    {
        foreach ($keys as $key) {
            session()->forget($key);
        }
    }
}

if (!function_exists('session_has_any')) {
    /**
     * Check if session has any of the given keys
     * 
     * @param array $keys Array of keys
     * @return bool True if any key exists
     */
    function session_has_any(array $keys): bool
    {
        foreach ($keys as $key) {
            if (session()->has($key)) {
                return true;
            }
        }
        
        return false;
    }
}

if (!function_exists('session_has_all')) {
    /**
     * Check if session has all of the given keys
     * 
     * @param array $keys Array of keys
     * @return bool True if all keys exist
     */
    function session_has_all(array $keys): bool
    {
        foreach ($keys as $key) {
            if (!session()->has($key)) {
                return false;
            }
        }
        
        return true;
    }
}

if (!function_exists('session_flush_except')) {
    /**
     * Flush session except specified keys
     * 
     * @param array $keys Keys to keep
     * @return void
     */
    function session_flush_except(array $keys): void
    {
        $all = session()->all();
        
        foreach ($keys as $key) {
            unset($all[$key]);
        }
        
        session()->flush();
        
        foreach ($keys as $key) {
            if (isset($all[$key])) {
                session([$key => $all[$key]]);
            }
        }
    }
}

if (!function_exists('cache_remember_or_fail')) {
    /**
     * Remember cache value or fail if callback throws exception
     * 
     * @param string $key Cache key
     * @param int $seconds TTL in seconds
     * @param callable $callback Callback to generate value
     * @return mixed Cached value
     * @throws Exception If callback fails
     */
    function cache_remember_or_fail(string $key, int $seconds, callable $callback)
    {
        if (Cache::has($key)) {
            return Cache::get($key);
        }
        
        try {
            $value = $callback();
            Cache::put($key, $value, $seconds);
            return $value;
        } catch (Exception $e) {
            throw $e;
        }
    }
}

if (!function_exists('cache_remember_or_default')) {
    /**
     * Remember cache value or return default if callback fails
     * 
     * @param string $key Cache key
     * @param int $seconds TTL in seconds
     * @param callable $callback Callback to generate value
     * @param mixed $default Default value
     * @return mixed Cached value or default
     */
    function cache_remember_or_default(string $key, int $seconds, callable $callback, $default = null)
    {
        if (Cache::has($key)) {
            return Cache::get($key);
        }
        
        try {
            $value = $callback();
            Cache::put($key, $value, $seconds);
            return $value;
        } catch (Exception $e) {
            return $default;
        }
    }
}

if (!function_exists('cache_remember_forever_or_fail')) {
    /**
     * Remember cache value forever or fail if callback throws exception
     * 
     * @param string $key Cache key
     * @param callable $callback Callback to generate value
     * @return mixed Cached value
     * @throws Exception If callback fails
     */
    function cache_remember_forever_or_fail(string $key, callable $callback)
    {
        if (Cache::has($key)) {
            return Cache::get($key);
        }
        
        try {
            $value = $callback();
            Cache::forever($key, $value);
            return $value;
        } catch (Exception $e) {
            throw $e;
        }
    }
}

if (!function_exists('cache_remember_forever_or_default')) {
    /**
     * Remember cache value forever or return default if callback fails
     * 
     * @param string $key Cache key
     * @param callable $callback Callback to generate value
     * @param mixed $default Default value
     * @return mixed Cached value or default
     */
    function cache_remember_forever_or_default(string $key, callable $callback, $default = null)
    {
        if (Cache::has($key)) {
            return Cache::get($key);
        }
        
        try {
            $value = $callback();
            Cache::forever($key, $value);
            return $value;
        } catch (Exception $e) {
            return $default;
        }
    }
}

if (!function_exists('cache_flush_by_pattern')) {
    /**
     * Flush cache keys matching pattern
     * 
     * @param string $pattern Pattern to match
     * @return int Number of keys flushed
     */
    function cache_flush_by_pattern(string $pattern): int
    {
        $count = 0;
        
        if (Cache::getStore() instanceof \Illuminate\Cache\TaggedCache) {
            // For tagged cache, we need to get all keys first
            $keys = Cache::getStore()->getRedis()->keys($pattern);
            
            foreach ($keys as $key) {
                if (Cache::forget($key)) {
                    $count++;
                }
            }
        } else {
            // For other cache stores, we can't easily pattern match
            // This is a limitation of most cache stores
            \Log::warning('Pattern-based cache flushing not supported for this cache store');
        }
        
        return $count;
    }
}

if (!function_exists('cache_get_or_put')) {
    /**
     * Get value from cache or put if not exists
     * 
     * @param string $key Cache key
     * @param mixed $value Value to store
     * @param int $seconds TTL in seconds
     * @return mixed Cached value
     */
    function cache_get_or_put(string $key, $value, int $seconds = 3600)
    {
        if (Cache::has($key)) {
            return Cache::get($key);
        }
        
        Cache::put($key, $value, $seconds);
        return $value;
    }
}

if (!function_exists('cache_get_or_put_forever')) {
    /**
     * Get value from cache or put forever if not exists
     * 
     * @param string $key Cache key
     * @param mixed $value Value to store
     * @return mixed Cached value
     */
    function cache_get_or_put_forever(string $key, $value)
    {
        if (Cache::has($key)) {
            return Cache::get($key);
        }
        
        Cache::forever($key, $value);
        return $value;
    }
}

if (!function_exists('session_get_or_put')) {
    /**
     * Get value from session or put if not exists
     * 
     * @param string $key Session key
     * @param mixed $value Value to store
     * @return mixed Session value
     */
    function session_get_or_put(string $key, $value)
    {
        if (session()->has($key)) {
            return session($key);
        }
        
        session([$key => $value]);
        return $value;
    }
}

if (!function_exists('session_get_or_put_multiple')) {
    /**
     * Get multiple values from session or put if not exists
     * 
     * @param array $data Key-value pairs
     * @return array Session values
     */
    function session_get_or_put_multiple(array $data): array
    {
        $result = [];
        
        foreach ($data as $key => $value) {
            $result[$key] = session_get_or_put($key, $value);
        }
        
        return $result;
    }
}

if (!function_exists('cache_has_and_not_expired')) {
    /**
     * Check if cache key exists and is not expired
     * 
     * @param string $key Cache key
     * @return bool True if exists and not expired
     */
    function cache_has_and_not_expired(string $key): bool
    {
        return Cache::has($key);
    }
}

if (!function_exists('cache_get_ttl')) {
    /**
     * Get TTL (Time To Live) of cache key
     * 
     * @param string $key Cache key
     * @return int|null TTL in seconds or null if not found
     */
    function cache_get_ttl(string $key): ?int
    {
        if (!Cache::has($key)) {
            return null;
        }
        
        // This is a simplified implementation
        // Real TTL calculation would depend on the cache store
        return null;
    }
}

if (!function_exists('session_cleanup_expired')) {
    /**
     * Clean up expired session data
     * 
     * @return int Number of cleaned sessions
     */
    function session_cleanup_expired(): int
    {
        $count = 0;
        $lifetime = config('session.lifetime', 120);
        $expiredTime = time() - ($lifetime * 60);
        
        // This is a simplified implementation
        // Real cleanup would depend on the session driver
        if (session_is_expired()) {
            session()->flush();
            $count = 1;
        }
        
        return $count;
    }
}

if (!function_exists('cache_remember_with_tags')) {
    /**
     * Remember cache value with tags
     * 
     * @param array $tags Cache tags
     * @param string $key Cache key
     * @param int $seconds TTL in seconds
     * @param callable $callback Callback to generate value
     * @return mixed Cached value
     */
    function cache_remember_with_tags(array $tags, string $key, int $seconds, callable $callback)
    {
        if (Cache::getStore() instanceof \Illuminate\Cache\TaggedCache) {
            return Cache::tags($tags)->remember($key, $seconds, $callback);
        }
        
        // Fallback for non-tagged cache stores
        return Cache::remember($key, $seconds, $callback);
    }
}

if (!function_exists('cache_flush_by_tags')) {
    /**
     * Flush cache by tags
     * 
     * @param array $tags Cache tags
     * @return bool True if successful
     */
    function cache_flush_by_tags(array $tags): bool
    {
        if (Cache::getStore() instanceof \Illuminate\Cache\TaggedCache) {
            Cache::tags($tags)->flush();
            return true;
        }
        
        return false;
    }
}

if (!function_exists('session_merge')) {
    /**
     * Merge data into session
     * 
     * @param string $key Session key
     * @param array $data Data to merge
     * @return void
     */
    function session_merge(string $key, array $data): void
    {
        $existing = session($key, []);
        $merged = array_merge($existing, $data);
        session([$key => $merged]);
    }
}

if (!function_exists('session_push')) {
    /**
     * Push value to session array
     * 
     * @param string $key Session key
     * @param mixed $value Value to push
     * @return void
     */
    function session_push(string $key, $value): void
    {
        $existing = session($key, []);
        $existing[] = $value;
        session([$key => $existing]);
    }
}

if (!function_exists('session_pop')) {
    /**
     * Pop value from session array
     * 
     * @param string $key Session key
     * @return mixed Popped value or null
     */
    function session_pop(string $key)
    {
        $existing = session($key, []);
        
        if (empty($existing)) {
            return null;
        }
        
        $value = array_pop($existing);
        session([$key => $existing]);
        
        return $value;
    }
}
