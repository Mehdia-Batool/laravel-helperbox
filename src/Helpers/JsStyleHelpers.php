<?php

/**
 * JavaScript-style Functional Helper Functions
 *
 * 40+ utilities inspired by Lodash/Underscore: map/filter/reduce variants,
 * collection transforms, function utilities (debounce/throttle/memoize),
 * and composition helpers. All declared with function_exists checks and
 * callable directly, e.g. unique_by($array, fn($x)=>$x['id']).
 *
 * @package Subhashladumor\LaravelHelperbox
 */

// ------------------------- Collection helpers -------------------------

if (!function_exists('flatten_deep')) {
    function flatten_deep(array $array): array
    {
        $result = [];
        $stack = [$array];
        while ($stack) {
            $curr = array_pop($stack);
            foreach ($curr as $value) {
                if (is_array($value)) {
                    $stack[] = $value;
                } else {
                    $result[] = $value;
                }
            }
        }
        return $result;
    }
}

if (!function_exists('recursive_map')) {
    function recursive_map(array $array, callable $callback): array
    {
        $out = [];
        foreach ($array as $key => $value) {
            $out[$key] = is_array($value)
                ? recursive_map($value, $callback)
                : $callback($value, $key);
        }
        return $out;
    }
}

if (!function_exists('chunk_array')) {
    function chunk_array(array $array, int $size): array
    {
        if ($size <= 0) return [$array];
        return array_chunk($array, $size);
    }
}

if (!function_exists('group_by')) {
    function group_by(array $array, callable|string $keySelector): array
    {
        $groups = [];
        foreach ($array as $item) {
            $key = is_callable($keySelector) ? $keySelector($item) : ($item[$keySelector] ?? null);
            $groups[$key][] = $item;
        }
        return $groups;
    }
}

if (!function_exists('unique_by')) {
    function unique_by(array $array, callable|string $keySelector): array
    {
        $seen = [];
        $result = [];
        foreach ($array as $item) {
            $key = is_callable($keySelector) ? $keySelector($item) : ($item[$keySelector] ?? null);
            if (!array_key_exists($key, $seen)) {
                $seen[$key] = true;
                $result[] = $item;
            }
        }
        return $result;
    }
}

if (!function_exists('zip_arrays')) {
    function zip_arrays(array ...$arrays): array
    {
        $length = 0;
        foreach ($arrays as $a) $length = max($length, count($a));
        $zipped = [];
        for ($i = 0; $i < $length; $i++) {
            $row = [];
            foreach ($arrays as $a) $row[] = $a[$i] ?? null;
            $zipped[] = $row;
        }
        return $zipped;
    }
}

if (!function_exists('shuffle_array')) {
    function shuffle_array(array $array): array
    {
        if (count($array) <= 1) return $array;
        $shuffled = array_values($array);
        for ($i = count($shuffled) - 1; $i > 0; $i--) {
            $j = random_int(0, $i);
            [$shuffled[$i], $shuffled[$j]] = [$shuffled[$j], $shuffled[$i]];
        }
        return $shuffled;
    }
}

if (!function_exists('pluck')) {
    function pluck(array $array, string $key): array
    {
        return array_map(fn($item) => is_array($item) ? ($item[$key] ?? null) : (is_object($item) ? ($item->{$key} ?? null) : null), $array);
    }
}

if (!function_exists('omit_keys')) {
    function omit_keys(array $array, array $keys): array
    {
        return array_diff_key($array, array_flip($keys));
    }
}

if (!function_exists('order_by')) {
    function order_by(array $array, callable|string $keySelector, string $direction = 'asc'): array
    {
        $sorted = $array;
        usort($sorted, function ($a, $b) use ($keySelector, $direction) {
            $ka = is_callable($keySelector) ? $keySelector($a) : ($a[$keySelector] ?? null);
            $kb = is_callable($keySelector) ? $keySelector($b) : ($b[$keySelector] ?? null);
            $cmp = $ka <=> $kb;
            return strtolower($direction) === 'desc' ? -$cmp : $cmp;
        });
        return $sorted;
    }
}

if (!function_exists('key_by')) {
    function key_by(array $array, callable|string $keySelector): array
    {
        $res = [];
        foreach ($array as $item) {
            $key = is_callable($keySelector) ? $keySelector($item) : ($item[$keySelector] ?? null);
            $res[$key] = $item;
        }
        return $res;
    }
}

if (!function_exists('intersection')) {
    function intersection(array $a, array $b): array
    {
        return array_values(array_intersect($a, $b));
    }
}

if (!function_exists('difference')) {
    function difference(array $a, array $b): array
    {
        return array_values(array_diff($a, $b));
    }
}

if (!function_exists('union_arrays')) {
    function union_arrays(array $a, array $b): array
    {
        return array_values(array_unique(array_merge($a, $b), SORT_REGULAR));
    }
}

if (!function_exists('without_values')) {
    function without_values(array $array, mixed ...$values): array
    {
        return array_values(array_diff($array, $values));
    }
}

if (!function_exists('compact_truthy')) {
    function compact_truthy(array $array): array
    {
        return array_values(array_filter($array));
    }
}

if (!function_exists('uniq')) {
    function uniq(array $array): array
    {
        return array_values(array_unique($array, SORT_REGULAR));
    }
}

if (!function_exists('sum_by')) {
    function sum_by(array $array, callable|string $selector): float|int
    {
        $sum = 0;
        foreach ($array as $item) {
            $v = is_callable($selector) ? $selector($item) : ($item[$selector] ?? 0);
            $sum += $v;
        }
        return $sum;
    }
}

if (!function_exists('mean_by')) {
    function mean_by(array $array, callable|string $selector): float
    {
        if (!$array) return 0.0;
        return sum_by($array, $selector) / count($array);
    }
}

if (!function_exists('median_by')) {
    function median_by(array $array, callable|string $selector): float
    {
        if (!$array) return 0.0;
        $values = array_map(fn($item) => is_callable($selector) ? $selector($item) : ($item[$selector] ?? 0), $array);
        sort($values);
        $n = count($values);
        $mid = intdiv($n, 2);
        return $n % 2 ? (float)$values[$mid] : ($values[$mid - 1] + $values[$mid]) / 2;
    }
}

if (!function_exists('clamp')) {
    function clamp(float|int $value, float|int $min, float|int $max): float|int
    {
        return max($min, min($max, $value));
    }
}

if (!function_exists('in_range')) {
    function in_range(float|int $value, float|int $start, float|int $end, bool $inclusive = false): bool
    {
        if ($start > $end) [$start, $end] = [$end, $start];
        return $inclusive ? ($value >= $start && $value <= $end) : ($value > $start && $value < $end);
    }
}

// ------------------------- Function helpers -------------------------

if (!function_exists('once')) {
    function once(callable $fn): callable
    {
        $called = false; $result = null;
        return function (...$args) use (&$called, &$result, $fn) {
            if (!$called) { $result = $fn(...$args); $called = true; }
            return $result;
        };
    }
}

if (!function_exists('memoize')) {
    function memoize(callable $fn, ?callable $keyResolver = null): callable
    {
        $cache = [];
        return function (...$args) use (&$cache, $fn, $keyResolver) {
            $key = $keyResolver ? $keyResolver(...$args) : md5(serialize($args));
            if (!array_key_exists($key, $cache)) {
                $cache[$key] = $fn(...$args);
            }
            return $cache[$key];
        };
    }
}

if (!function_exists('debounce')) {
    function debounce(callable $fn, int $milliseconds): callable
    {
        $lastTime = 0; $lastArgs = null; $timerActive = false;
        return function (...$args) use (&$lastTime, &$lastArgs, &$timerActive, $fn, $milliseconds) {
            $now = (int) (microtime(true) * 1000);
            $lastArgs = $args; $lastTime = $now; $timerActive = true;
            // Cooperative debounce: execute only if gap elapsed since last call on next tick
            register_shutdown_function(function () use (&$lastTime, &$lastArgs, &$timerActive, $fn, $milliseconds) {
                if (!$timerActive) return;
                $now = (int) (microtime(true) * 1000);
                if ($now - $lastTime >= $milliseconds && $lastArgs !== null) {
                    $fn(...$lastArgs);
                    $timerActive = false; $lastArgs = null;
                }
            });
        };
    }
}

if (!function_exists('throttle')) {
    function throttle(callable $fn, int $milliseconds): callable
    {
        $lastExec = 0; $queuedArgs = null;
        return function (...$args) use (&$lastExec, &$queuedArgs, $fn, $milliseconds) {
            $now = (int) (microtime(true) * 1000);
            if ($now - $lastExec >= $milliseconds) {
                $lastExec = $now; return $fn(...$args);
            }
            $queuedArgs = $args;
            register_shutdown_function(function () use (&$lastExec, &$queuedArgs, $fn, $milliseconds) {
                $now = (int) (microtime(true) * 1000);
                if ($queuedArgs !== null && $now - $lastExec >= $milliseconds) {
                    $lastExec = $now; $fn(...$queuedArgs); $queuedArgs = null;
                }
            });
            return null;
        };
    }
}

if (!function_exists('pipe')) {
    function pipe(callable ...$fns): callable
    {
        return function ($value) use ($fns) {
            foreach ($fns as $fn) { $value = $fn($value); }
            return $value;
        };
    }
}

if (!function_exists('compose')) {
    function compose(callable ...$fns): callable
    {
        return function ($value) use ($fns) {
            for ($i = count($fns) - 1; $i >= 0; $i--) { $value = $fns[$i]($value); }
            return $value;
        };
    }
}

if (!function_exists('deep_clone')) {
    function deep_clone(mixed $value): mixed
    {
        return unserialize(serialize($value));
    }
}

if (!function_exists('deep_equal')) {
    function deep_equal(mixed $a, mixed $b): bool
    {
        return $a == $b; // non-strict deep comparison
    }
}

if (!function_exists('retry_call')) {
    function retry_call(int $times, int $sleepMs, callable $fn, ?callable $onRetry = null): mixed
    {
        $attempt = 0; $last = null;
        while ($attempt < $times) {
            try { return $fn($attempt); } catch (\Throwable $e) {
                $last = $e; $attempt++;
                if ($onRetry) { $onRetry($attempt, $e); }
                usleep($sleepMs * 1000);
            }
        }
        if ($last) throw $last;
        return null;
    }
}

if (!function_exists('delay_ms')) {
    function delay_ms(int $milliseconds, ?callable $fn = null): void
    {
        usleep(max(0, $milliseconds) * 1000);
        if ($fn) { $fn(); }
    }
}

if (!function_exists('curry')) {
    function curry(callable $fn, int $arity = null): callable
    {
        $arity = $arity ?? (new \ReflectionFunction(\Closure::fromCallable($fn)))->getNumberOfParameters();
        $acc = function ($args) use (&$acc, $fn, $arity) {
            return function (...$next) use ($args, $fn, $arity, $acc) {
                $all = array_merge($args, $next);
                return count($all) >= $arity ? $fn(...$all) : $acc($all);
            };
        };
        return $acc([]);
    }
}

if (!function_exists('partial')) {
    function partial(callable $fn, mixed ...$bound): callable
    {
        return function (...$args) use ($fn, $bound) { return $fn(...array_merge($bound, $args)); };
    }
}

if (!function_exists('tap_value')) {
    function tap_value(mixed $value, callable $fn): mixed
    {
        $fn($value); return $value;
    }
}

if (!function_exists('times')) {
    function times(int $n, callable $iteratee): array
    {
        $out = [];
        for ($i = 0; $i < $n; $i++) { $out[] = $iteratee($i); }
        return $out;
    }
}

if (!function_exists('range_array')) {
    function range_array(int $start, int $end, int $step = 1): array
    {
        if ($step === 0) return [];
        return range($start, $end, $step);
    }
}

if (!function_exists('sample')) {
    function sample(array $array): mixed
    {
        if (!$array) return null;
        return $array[array_rand($array)];
    }
}

if (!function_exists('sample_size')) {
    function sample_size(array $array, int $count): array
    {
        if ($count <= 0) return [];
        if ($count >= count($array)) return shuffle_array($array);
        $keys = array_rand($array, $count);
        $keys = is_array($keys) ? $keys : [$keys];
        $res = [];
        foreach ($keys as $k) $res[] = $array[$k];
        return $res;
    }
}

?>


