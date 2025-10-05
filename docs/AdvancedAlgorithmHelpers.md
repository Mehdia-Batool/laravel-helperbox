### AdvancedAlgorithmHelpers

Heaps, graphs, tries, segment trees, Fenwick trees, matrices, and more.

#### Function Index

- array_to_heap(array $array, bool $maxHeap = true): array
- heap_extract_min(array &$heap)
- heap_extract_max(array &$heap)
- graph_shortest_path(array $graph, $start, $end): array|false
- graph_has_cycle(array $graph, bool $directed = true): bool
- graph_topological_sort(array $graph): array|false
- union_find_create(int $n): array
- union_find_union(array &$uf, int $a, int $b): void
- union_find_find(array &$uf, int $x): int
- trie_insert(array &$trie, string $word): void
- trie_search(array $trie, string $word): bool
- trie_prefix_search(array $trie, string $prefix): array
- segment_tree_build(array $array): array
- segment_tree_query(array $tree, int $l, int $r): int
- segment_tree_update(array &$tree, int $index, int $value): void
- fenwick_tree_build(array $array): array
- fenwick_tree_sum(array $tree, int $index): int
- fenwick_tree_update(array &$tree, int $index, int $delta): void
- matrix_rotate_90(array $matrix): array
- matrix_spiral_order(array $matrix): array

Internal helpers exposed in this file (for reference): `heapify`, `hasCycleDFS`, `collectWords`, `buildSegmentTree`, `querySegmentTree`, `updateSegmentTree`, `fenwickUpdate`.

#### Examples

```php
$heap = array_to_heap([3,1,4,1,5], true);
$min = heap_extract_min($heap);
```


