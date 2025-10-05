### ArrayHelpers

Practical array utilities for flattening, grouping, plucking, keyed inserts, partitions, CSV conversion, padding, randomization, and more.

#### Function Index

- array_flatten_recursive(array $array, int $depth = 0): array
- array_to_xml(array $array, string $rootElement = 'root', string $xmlVersion = '1.0', string $encoding = 'UTF-8'): string
- array_shuffle_assoc(array $array): array
- array_key_case(array $array, int $case = CASE_LOWER): array
- array_group_by(array $array, callable|string $key): array
- array_multi_search(array $array, mixed $search, bool $strict = false): array
- array_pluck_recursive(array $array, string $key): array
- array_random_key(array $array)
- array_random_value(array $array)
- array_insert_after(array $array, mixed $key, mixed $newKey, mixed $newValue): array
- array_insert_before(array $array, mixed $key, mixed $newKey, mixed $newValue): array
- array_first_key(array $array)
- array_last_key(array $array)
- array_first_value(array $array)
- array_last_value(array $array)
- array_partition(array $array, callable $callback): array
- array_is_assoc(array $array): bool
- array_is_list(array $array): bool
- array_only_keys(array $array, array $keys): array
- array_except_keys(array $array, array $keys): array
- array_merge_recursive_distinct(array $array1, array $array2): array
- array_diff_recursive(array $array1, array $array2): array
- array_to_csv(array $array, string $delimiter = ',', string $enclosure = '"'): string
- array_from_csv(string $csv, string $delimiter = ',', string $enclosure = '"'): array
- array_split_chunks(array $array, int $size): array
- array_pad_left(array $array, int $size, mixed $value = null): array
- array_pad_right(array $array, int $size, mixed $value = null): array
- array_to_collection(array $array): \Illuminate\Support\Collection
- array_random_subset(array $array, int $count): array
- array_to_object(array $array): object

#### Examples

```php
$flat = array_flatten_recursive([[1, [2]], 3]); // [1,2,3]

$groups = array_group_by([
  ['id' => 1, 'role' => 'admin'],
  ['id' => 2, 'role' => 'user'],
], 'role');
// ['admin' => [...], 'user' => [...]]

$csv = array_to_csv([
  ['id' => 1, 'name' => 'A'],
  ['id' => 2, 'name' => 'B'],
]);
```


