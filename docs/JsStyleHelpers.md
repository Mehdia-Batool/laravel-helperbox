### JsStyleHelpers

Lodash/Underscore-style utilities for PHP collections and functions.

#### Function Index

- flatten_deep(array $array): array
- recursive_map(array $array, callable $callback): array
- chunk_array(array $array, int $size): array
- group_by(array $array, callable|string $keySelector): array
- unique_by(array $array, callable|string $keySelector): array
- zip_arrays(array ...$arrays): array
- shuffle_array(array $array): array
- pluck(array $array, string $key): array
- omit_keys(array $array, array $keys): array
- order_by(array $array, callable|string $keySelector, string $direction = 'asc'): array
- key_by(array $array, callable|string $keySelector): array
- intersection(array $a, array $b): array
- difference(array $a, array $b): array
- union_arrays(array $a, array $b): array
- without_values(array $array, mixed ...$values): array
- compact_truthy(array $array): array
- uniq(array $array): array
- sum_by(array $array, callable|string $selector): float|int
- mean_by(array $array, callable|string $selector): float
- median_by(array $array, callable|string $selector): float
- clamp(float|int $value, float|int $min, float|int $max): float|int
- in_range(float|int $value, float|int $start, float|int $end, bool $inclusive = false): bool
- once(callable $fn): callable
- memoize(callable $fn, ?callable $keyResolver = null): callable
- debounce(callable $fn, int $milliseconds): callable
- throttle(callable $fn, int $milliseconds): callable
- pipe(callable ...$fns): callable
- compose(callable ...$fns): callable
- deep_clone(mixed $value): mixed
- deep_equal(mixed $a, mixed $b): bool
- retry_call(int $times, int $sleepMs, callable $fn, ?callable $onRetry = null): mixed
- delay_ms(int $milliseconds, ?callable $fn = null): void
- curry(callable $fn, int $arity = null): callable
- partial(callable $fn, mixed ...$bound): callable
- tap_value(mixed $value, callable $fn): mixed
- times(int $n, callable $iteratee): array
- range_array(int $start, int $end, int $step = 1): array
- sample(array $array): mixed
- sample_size(array $array, int $count): array


