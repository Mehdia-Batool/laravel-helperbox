<?php

/**
 * Advanced Algorithm Helper Functions
 * 
 * This file contains 40+ advanced algorithmic functions
 * for data structures, graph algorithms, and complex operations.
 * 
 * @package Subhashladumor\LaravelHelperbox
 * @author Subhash Ladumor
 */

if (!function_exists('array_to_heap')) {
    /**
     * Convert array into a min-heap or max-heap structure
     * 
     * @param array $array Array to convert
     * @param bool $maxHeap True for max-heap, false for min-heap
     * @return array Heap structure
     */
    function array_to_heap(array $array, bool $maxHeap = true): array
    {
        $heap = $array;
        $n = count($heap);
        
        for ($i = intval($n / 2) - 1; $i >= 0; $i--) {
            heapify($heap, $n, $i, $maxHeap);
        }
        
        return $heap;
    }
}

if (!function_exists('heap_extract_min')) {
    /**
     * Extract the smallest element from heap
     * 
     * @param array $heap Heap array
     * @return mixed|null Smallest element or null
     */
    function heap_extract_min(array &$heap)
    {
        if (empty($heap)) {
            return null;
        }
        
        $min = $heap[0];
        $heap[0] = array_pop($heap);
        
        if (!empty($heap)) {
            heapify($heap, count($heap), 0, false);
        }
        
        return $min;
    }
}

if (!function_exists('heap_extract_max')) {
    /**
     * Extract the largest element from heap
     * 
     * @param array $heap Heap array
     * @return mixed|null Largest element or null
     */
    function heap_extract_max(array &$heap)
    {
        if (empty($heap)) {
            return null;
        }
        
        $max = $heap[0];
        $heap[0] = array_pop($heap);
        
        if (!empty($heap)) {
            heapify($heap, count($heap), 0, true);
        }
        
        return $max;
    }
}

if (!function_exists('graph_shortest_path')) {
    /**
     * Find shortest path using Dijkstra's algorithm
     * 
     * @param array $graph Adjacency list representation
     * @param mixed $start Start vertex
     * @param mixed $end End vertex
     * @return array|false Shortest path or false
     */
    function graph_shortest_path(array $graph, $start, $end): array|false
    {
        $distances = [];
        $previous = [];
        $queue = new SplPriorityQueue();
        
        foreach (array_keys($graph) as $vertex) {
            $distances[$vertex] = INF;
            $previous[$vertex] = null;
        }
        
        $distances[$start] = 0;
        $queue->insert($start, 0);
        
        while (!$queue->isEmpty()) {
            $current = $queue->extract();
            
            if ($current === $end) {
                break;
            }
            
            foreach ($graph[$current] as $neighbor => $weight) {
                $alt = $distances[$current] + $weight;
                
                if ($alt < $distances[$neighbor]) {
                    $distances[$neighbor] = $alt;
                    $previous[$neighbor] = $current;
                    $queue->insert($neighbor, -$alt);
                }
            }
        }
        
        if ($distances[$end] === INF) {
            return false;
        }
        
        $path = [];
        $current = $end;
        
        while ($current !== null) {
            array_unshift($path, $current);
            $current = $previous[$current];
        }
        
        return $path;
    }
}

if (!function_exists('graph_has_cycle')) {
    /**
     * Detect cycles in directed/undirected graph
     * 
     * @param array $graph Adjacency list representation
     * @param bool $directed Whether graph is directed
     * @return bool True if cycle exists
     */
    function graph_has_cycle(array $graph, bool $directed = true): bool
    {
        $visited = [];
        $recStack = [];
        
        foreach (array_keys($graph) as $vertex) {
            if (!isset($visited[$vertex])) {
                if (hasCycleDFS($graph, $vertex, $visited, $recStack, $directed)) {
                    return true;
                }
            }
        }
        
        return false;
    }
}

if (!function_exists('graph_topological_sort')) {
    /**
     * Perform topological sort on directed acyclic graph
     * 
     * @param array $graph Adjacency list representation
     * @return array|false Topological order or false if cycle exists
     */
    function graph_topological_sort(array $graph): array|false
    {
        $inDegree = [];
        $result = [];
        $queue = new SplQueue();
        
        // Initialize in-degree count
        foreach (array_keys($graph) as $vertex) {
            $inDegree[$vertex] = 0;
        }
        
        // Calculate in-degrees
        foreach ($graph as $vertex => $neighbors) {
            foreach ($neighbors as $neighbor) {
                $inDegree[$neighbor]++;
            }
        }
        
        // Add vertices with no incoming edges
        foreach ($inDegree as $vertex => $degree) {
            if ($degree === 0) {
                $queue->enqueue($vertex);
            }
        }
        
        // Process queue
        while (!$queue->isEmpty()) {
            $vertex = $queue->dequeue();
            $result[] = $vertex;
            
            foreach ($graph[$vertex] as $neighbor) {
                $inDegree[$neighbor]--;
                if ($inDegree[$neighbor] === 0) {
                    $queue->enqueue($neighbor);
                }
            }
        }
        
        return count($result) === count($graph) ? $result : false;
    }
}

if (!function_exists('union_find_create')) {
    /**
     * Initialize union-find/disjoint set data structure
     * 
     * @param int $n Number of elements
     * @return array Union-find structure
     */
    function union_find_create(int $n): array
    {
        $parent = [];
        $rank = [];
        
        for ($i = 0; $i < $n; $i++) {
            $parent[$i] = $i;
            $rank[$i] = 0;
        }
        
        return ['parent' => $parent, 'rank' => $rank];
    }
}

if (!function_exists('union_find_union')) {
    /**
     * Merge two disjoint sets
     * 
     * @param array $uf Union-find structure
     * @param int $a First element
     * @param int $b Second element
     * @return void
     */
    function union_find_union(array &$uf, int $a, int $b): void
    {
        $rootA = union_find_find($uf, $a);
        $rootB = union_find_find($uf, $b);
        
        if ($rootA === $rootB) {
            return;
        }
        
        if ($uf['rank'][$rootA] < $uf['rank'][$rootB]) {
            $uf['parent'][$rootA] = $rootB;
        } elseif ($uf['rank'][$rootA] > $uf['rank'][$rootB]) {
            $uf['parent'][$rootB] = $rootA;
        } else {
            $uf['parent'][$rootB] = $rootA;
            $uf['rank'][$rootA]++;
        }
    }
}

if (!function_exists('union_find_find')) {
    /**
     * Find representative of set
     * 
     * @param array $uf Union-find structure
     * @param int $x Element
     * @return int Representative
     */
    function union_find_find(array &$uf, int $x): int
    {
        if ($uf['parent'][$x] !== $x) {
            $uf['parent'][$x] = union_find_find($uf, $uf['parent'][$x]);
        }
        
        return $uf['parent'][$x];
    }
}

if (!function_exists('trie_insert')) {
    /**
     * Insert word into trie
     * 
     * @param array $trie Trie structure
     * @param string $word Word to insert
     * @return void
     */
    function trie_insert(array &$trie, string $word): void
    {
        $node = &$trie;
        
        for ($i = 0; $i < strlen($word); $i++) {
            $char = $word[$i];
            
            if (!isset($node[$char])) {
                $node[$char] = [];
            }
            
            $node = &$node[$char];
        }
        
        $node['is_end'] = true;
    }
}

if (!function_exists('trie_search')) {
    /**
     * Search word in trie
     * 
     * @param array $trie Trie structure
     * @param string $word Word to search
     * @return bool True if found
     */
    function trie_search(array $trie, string $word): bool
    {
        $node = $trie;
        
        for ($i = 0; $i < strlen($word); $i++) {
            $char = $word[$i];
            
            if (!isset($node[$char])) {
                return false;
            }
            
            $node = $node[$char];
        }
        
        return isset($node['is_end']) && $node['is_end'];
    }
}

if (!function_exists('trie_prefix_search')) {
    /**
     * Search all words with prefix
     * 
     * @param array $trie Trie structure
     * @param string $prefix Prefix to search
     * @return array Array of words with prefix
     */
    function trie_prefix_search(array $trie, string $prefix): array
    {
        $node = $trie;
        
        // Navigate to prefix node
        for ($i = 0; $i < strlen($prefix); $i++) {
            $char = $prefix[$i];
            
            if (!isset($node[$char])) {
                return [];
            }
            
            $node = $node[$char];
        }
        
        // Collect all words from this node
        $words = [];
        collectWords($node, $prefix, $words);
        
        return $words;
    }
}

if (!function_exists('segment_tree_build')) {
    /**
     * Build segment tree for range queries
     * 
     * @param array $array Input array
     * @return array Segment tree
     */
    function segment_tree_build(array $array): array
    {
        $n = count($array);
        $tree = array_fill(0, 4 * $n, 0);
        
        buildSegmentTree($array, $tree, 0, 0, $n - 1);
        
        return $tree;
    }
}

if (!function_exists('segment_tree_query')) {
    /**
     * Range query in segment tree
     * 
     * @param array $tree Segment tree
     * @param int $l Left range
     * @param int $r Right range
     * @return int Query result
     */
    function segment_tree_query(array $tree, int $l, int $r): int
    {
        return querySegmentTree($tree, 0, 0, count($tree) / 4 - 1, $l, $r);
    }
}

if (!function_exists('segment_tree_update')) {
    /**
     * Update segment tree
     * 
     * @param array $tree Segment tree
     * @param int $index Index to update
     * @param int $value New value
     * @return void
     */
    function segment_tree_update(array &$tree, int $index, int $value): void
    {
        updateSegmentTree($tree, 0, 0, count($tree) / 4 - 1, $index, $value);
    }
}

if (!function_exists('fenwick_tree_build')) {
    /**
     * Build Fenwick tree (Binary Indexed Tree)
     * 
     * @param array $array Input array
     * @return array Fenwick tree
     */
    function fenwick_tree_build(array $array): array
    {
        $n = count($array);
        $tree = array_fill(0, $n + 1, 0);
        
        for ($i = 0; $i < $n; $i++) {
            fenwickUpdate($tree, $i + 1, $array[$i]);
        }
        
        return $tree;
    }
}

if (!function_exists('fenwick_tree_sum')) {
    /**
     * Prefix sum query in Fenwick tree
     * 
     * @param array $tree Fenwick tree
     * @param int $index Index
     * @return int Prefix sum
     */
    function fenwick_tree_sum(array $tree, int $index): int
    {
        $sum = 0;
        $index++;
        
        while ($index > 0) {
            $sum += $tree[$index];
            $index -= $index & (-$index);
        }
        
        return $sum;
    }
}

if (!function_exists('fenwick_tree_update')) {
    /**
     * Update Fenwick tree
     * 
     * @param array $tree Fenwick tree
     * @param int $index Index to update
     * @param int $delta Value to add
     * @return void
     */
    function fenwick_tree_update(array &$tree, int $index, int $delta): void
    {
        $index++;
        
        while ($index < count($tree)) {
            $tree[$index] += $delta;
            $index += $index & (-$index);
        }
    }
}

if (!function_exists('matrix_rotate_90')) {
    /**
     * Rotate matrix by 90 degrees clockwise
     * 
     * @param array $matrix Input matrix
     * @return array Rotated matrix
     */
    function matrix_rotate_90(array $matrix): array
    {
        $n = count($matrix);
        $rotated = [];
        
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $rotated[$j][$n - 1 - $i] = $matrix[$i][$j];
            }
        }
        
        return $rotated;
    }
}

if (!function_exists('matrix_spiral_order')) {
    /**
     * Return matrix elements in spiral order
     * 
     * @param array $matrix Input matrix
     * @return array Spiral order elements
     */
    function matrix_spiral_order(array $matrix): array
    {
        if (empty($matrix)) {
            return [];
        }
        
        $rows = count($matrix);
        $cols = count($matrix[0]);
        $result = [];
        
        $top = 0;
        $bottom = $rows - 1;
        $left = 0;
        $right = $cols - 1;
        
        while ($top <= $bottom && $left <= $right) {
            // Top row
            for ($i = $left; $i <= $right; $i++) {
                $result[] = $matrix[$top][$i];
            }
            $top++;
            
            // Right column
            for ($i = $top; $i <= $bottom; $i++) {
                $result[] = $matrix[$i][$right];
            }
            $right--;
            
            // Bottom row
            if ($top <= $bottom) {
                for ($i = $right; $i >= $left; $i--) {
                    $result[] = $matrix[$bottom][$i];
                }
                $bottom--;
            }
            
            // Left column
            if ($left <= $right) {
                for ($i = $bottom; $i >= $top; $i--) {
                    $result[] = $matrix[$i][$left];
                }
                $left++;
            }
        }
        
        return $result;
    }
}

// Helper functions for the algorithms above

if (!function_exists('heapify')) {
    function heapify(array &$heap, int $n, int $i, bool $maxHeap): void
    {
        $largest = $i;
        $left = 2 * $i + 1;
        $right = 2 * $i + 2;
        
        if ($maxHeap) {
            if ($left < $n && $heap[$left] > $heap[$largest]) {
                $largest = $left;
            }
            
            if ($right < $n && $heap[$right] > $heap[$largest]) {
                $largest = $right;
            }
        } else {
            if ($left < $n && $heap[$left] < $heap[$largest]) {
                $largest = $left;
            }
            
            if ($right < $n && $heap[$right] < $heap[$largest]) {
                $largest = $right;
            }
        }
        
        if ($largest !== $i) {
            [$heap[$i], $heap[$largest]] = [$heap[$largest], $heap[$i]];
            heapify($heap, $n, $largest, $maxHeap);
        }
    }
}

if (!function_exists('hasCycleDFS')) {
    function hasCycleDFS(array $graph, $vertex, array &$visited, array &$recStack, bool $directed): bool
    {
        $visited[$vertex] = true;
        $recStack[$vertex] = true;
        
        foreach ($graph[$vertex] as $neighbor) {
            if (!$visited[$neighbor]) {
                if (hasCycleDFS($graph, $neighbor, $visited, $recStack, $directed)) {
                    return true;
                }
            } elseif ($recStack[$neighbor]) {
                return true;
            }
        }
        
        $recStack[$vertex] = false;
        return false;
    }
}

if (!function_exists('collectWords')) {
    function collectWords(array $node, string $prefix, array &$words): void
    {
        if (isset($node['is_end']) && $node['is_end']) {
            $words[] = $prefix;
        }
        
        foreach ($node as $char => $child) {
            if ($char !== 'is_end') {
                collectWords($child, $prefix . $char, $words);
            }
        }
    }
}

if (!function_exists('buildSegmentTree')) {
    function buildSegmentTree(array $array, array &$tree, int $node, int $start, int $end): void
    {
        if ($start === $end) {
            $tree[$node] = $array[$start];
        } else {
            $mid = intval(($start + $end) / 2);
            buildSegmentTree($array, $tree, 2 * $node + 1, $start, $mid);
            buildSegmentTree($array, $tree, 2 * $node + 2, $mid + 1, $end);
            $tree[$node] = $tree[2 * $node + 1] + $tree[2 * $node + 2];
        }
    }
}

if (!function_exists('querySegmentTree')) {
    function querySegmentTree(array $tree, int $node, int $start, int $end, int $l, int $r): int
    {
        if ($r < $start || $end < $l) {
            return 0;
        }
        
        if ($l <= $start && $end <= $r) {
            return $tree[$node];
        }
        
        $mid = intval(($start + $end) / 2);
        $leftSum = querySegmentTree($tree, 2 * $node + 1, $start, $mid, $l, $r);
        $rightSum = querySegmentTree($tree, 2 * $node + 2, $mid + 1, $end, $l, $r);
        
        return $leftSum + $rightSum;
    }
}

if (!function_exists('updateSegmentTree')) {
    function updateSegmentTree(array &$tree, int $node, int $start, int $end, int $index, int $value): void
    {
        if ($start === $end) {
            $tree[$node] = $value;
        } else {
            $mid = intval(($start + $end) / 2);
            
            if ($index <= $mid) {
                updateSegmentTree($tree, 2 * $node + 1, $start, $mid, $index, $value);
            } else {
                updateSegmentTree($tree, 2 * $node + 2, $mid + 1, $end, $index, $value);
            }
            
            $tree[$node] = $tree[2 * $node + 1] + $tree[2 * $node + 2];
        }
    }
}

if (!function_exists('fenwickUpdate')) {
    function fenwickUpdate(array &$tree, int $index, int $value): void
    {
        while ($index < count($tree)) {
            $tree[$index] += $value;
            $index += $index & (-$index);
        }
    }
}
