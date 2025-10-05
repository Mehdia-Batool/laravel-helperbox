<?php

/**
 * Array Helper Functions
 * 
 * This file contains 30+ advanced array manipulation functions
 * for complex array operations, transformations, and searches.
 * 
 * @package Subhashladumor\LaravelHelperbox
 * @author Subhash Ladumor
 */

if (!function_exists('array_flatten_recursive')) {
    /**
     * Flattens a multi-dimensional array recursively
     * 
     * @param array $array The array to flatten
     * @param int $depth Maximum depth to flatten (0 = unlimited)
     * @return array Flattened array
     */
    function array_flatten_recursive(array $array, int $depth = 0): array
    {
        $result = [];
        $currentDepth = 0;
        
        $flatten = function($arr, $currentDepth) use (&$flatten, &$result, $depth) {
            foreach ($arr as $item) {
                if (is_array($item) && ($depth === 0 || $currentDepth < $depth)) {
                    $flatten($item, $currentDepth + 1);
                } else {
                    $result[] = $item;
                }
            }
        };
        
        $flatten($array, $currentDepth);
        return $result;
    }
}

if (!function_exists('array_to_xml')) {
    /**
     * Converts an array into XML format
     * 
     * @param array $array The array to convert
     * @param string $rootElement Root element name
     * @param string $xmlVersion XML version
     * @param string $encoding XML encoding
     * @return string XML string
     */
    function array_to_xml(array $array, string $rootElement = 'root', string $xmlVersion = '1.0', string $encoding = 'UTF-8'): string
    {
        $xml = new \SimpleXMLElement("<?xml version=\"$xmlVersion\" encoding=\"$encoding\"?><$rootElement></$rootElement>");
        
        $addToXml = function($data, $xml) use (&$addToXml) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    if (is_numeric($key)) {
                        $key = 'item';
                    }
                    $subnode = $xml->addChild($key);
                    $addToXml($value, $subnode);
                } else {
                    if (is_numeric($key)) {
                        $key = 'item';
                    }
                    $xml->addChild($key, htmlspecialchars($value));
                }
            }
        };
        
        $addToXml($array, $xml);
        return $xml->asXML();
    }
}

if (!function_exists('array_shuffle_assoc')) {
    /**
     * Shuffles associative arrays while preserving keys
     * 
     * @param array $array The array to shuffle
     * @return array Shuffled array with preserved keys
     */
    function array_shuffle_assoc(array $array): array
    {
        $keys = array_keys($array);
        shuffle($keys);
        $shuffled = [];
        
        foreach ($keys as $key) {
            $shuffled[$key] = $array[$key];
        }
        
        return $shuffled;
    }
}

if (!function_exists('array_key_case')) {
    /**
     * Changes array keys to upper/lowercase
     * 
     * @param array $array The array to modify
     * @param int $case CASE_UPPER or CASE_LOWER
     * @return array Array with modified key cases
     */
    function array_key_case(array $array, int $case = CASE_LOWER): array
    {
        $result = [];
        
        foreach ($array as $key => $value) {
            $newKey = ($case === CASE_UPPER) ? strtoupper($key) : strtolower($key);
            $result[$newKey] = $value;
        }
        
        return $result;
    }
}

if (!function_exists('array_group_by')) {
    /**
     * Groups an array of items by a key or callback
     * 
     * @param array $array The array to group
     * @param string|callable $key Key to group by or callback function
     * @return array Grouped array
     */
    function array_group_by(array $array, $key): array
    {
        $result = [];
        
        foreach ($array as $item) {
            if (is_callable($key)) {
                $groupKey = $key($item);
            } else {
                $groupKey = is_array($item) ? ($item[$key] ?? null) : ($item->$key ?? null);
            }
            
            if ($groupKey !== null) {
                $result[$groupKey][] = $item;
            }
        }
        
        return $result;
    }
}

if (!function_exists('array_multi_search')) {
    /**
     * Searches recursively for a value in multi-dimensional array
     * 
     * @param array $array The array to search
     * @param mixed $search The value to search for
     * @param bool $strict Whether to use strict comparison
     * @return array Array of paths where the value was found
     */
    function array_multi_search(array $array, $search, bool $strict = false): array
    {
        $paths = [];
        
        $searchRecursive = function($arr, $currentPath = []) use (&$searchRecursive, &$paths, $search, $strict) {
            foreach ($arr as $key => $value) {
                $newPath = array_merge($currentPath, [$key]);
                
                if (is_array($value)) {
                    $searchRecursive($value, $newPath);
                } else {
                    if ($strict ? $value === $search : $value == $search) {
                        $paths[] = $newPath;
                    }
                }
            }
        };
        
        $searchRecursive($array);
        return $paths;
    }
}

if (!function_exists('array_pluck_recursive')) {
    /**
     * Plucks values from nested arrays
     * 
     * @param array $array The array to pluck from
     * @param string $key The key to pluck
     * @return array Array of plucked values
     */
    function array_pluck_recursive(array $array, string $key): array
    {
        $result = [];
        
        $pluckRecursive = function($arr) use (&$pluckRecursive, &$result, $key) {
            foreach ($arr as $item) {
                if (is_array($item)) {
                    if (isset($item[$key])) {
                        $result[] = $item[$key];
                    }
                    $pluckRecursive($item);
                }
            }
        };
        
        $pluckRecursive($array);
        return $result;
    }
}

if (!function_exists('array_random_key')) {
    /**
     * Returns a random key from the array
     * 
     * @param array $array The array to get key from
     * @return mixed Random key or null if array is empty
     */
    function array_random_key(array $array)
    {
        if (empty($array)) {
            return null;
        }
        
        $keys = array_keys($array);
        return $keys[array_rand($keys)];
    }
}

if (!function_exists('array_random_value')) {
    /**
     * Returns a random value from the array
     * 
     * @param array $array The array to get value from
     * @return mixed Random value or null if array is empty
     */
    function array_random_value(array $array)
    {
        if (empty($array)) {
            return null;
        }
        
        return $array[array_rand($array)];
    }
}

if (!function_exists('array_insert_after')) {
    /**
     * Insert new key/value pair after specific key
     * 
     * @param array $array The array to modify
     * @param mixed $key The key to insert after
     * @param mixed $newKey The new key
     * @param mixed $newValue The new value
     * @return array Modified array
     */
    function array_insert_after(array $array, $key, $newKey, $newValue): array
    {
        $result = [];
        $inserted = false;
        
        foreach ($array as $k => $v) {
            $result[$k] = $v;
            
            if ($k === $key && !$inserted) {
                $result[$newKey] = $newValue;
                $inserted = true;
            }
        }
        
        if (!$inserted) {
            $result[$newKey] = $newValue;
        }
        
        return $result;
    }
}

if (!function_exists('array_insert_before')) {
    /**
     * Insert new key/value pair before specific key
     * 
     * @param array $array The array to modify
     * @param mixed $key The key to insert before
     * @param mixed $newKey The new key
     * @param mixed $newValue The new value
     * @return array Modified array
     */
    function array_insert_before(array $array, $key, $newKey, $newValue): array
    {
        $result = [];
        $inserted = false;
        
        foreach ($array as $k => $v) {
            if ($k === $key && !$inserted) {
                $result[$newKey] = $newValue;
                $inserted = true;
            }
            $result[$k] = $v;
        }
        
        if (!$inserted) {
            $result[$newKey] = $newValue;
        }
        
        return $result;
    }
}

if (!function_exists('array_first_key')) {
    /**
     * Get the first key from array
     * 
     * @param array $array The array
     * @return mixed First key or null if empty
     */
    function array_first_key(array $array)
    {
        if (empty($array)) {
            return null;
        }
        
        return array_key_first($array);
    }
}

if (!function_exists('array_last_key')) {
    /**
     * Get the last key from array
     * 
     * @param array $array The array
     * @return mixed Last key or null if empty
     */
    function array_last_key(array $array)
    {
        if (empty($array)) {
            return null;
        }
        
        return array_key_last($array);
    }
}

if (!function_exists('array_first_value')) {
    /**
     * Get the first value from array
     * 
     * @param array $array The array
     * @return mixed First value or null if empty
     */
    function array_first_value(array $array)
    {
        if (empty($array)) {
            return null;
        }
        
        return reset($array);
    }
}

if (!function_exists('array_last_value')) {
    /**
     * Get the last value from array
     * 
     * @param array $array The array
     * @return mixed Last value or null if empty
     */
    function array_last_value(array $array)
    {
        if (empty($array)) {
            return null;
        }
        
        return end($array);
    }
}

if (!function_exists('array_partition')) {
    /**
     * Partition array into two groups based on condition
     * 
     * @param array $array The array to partition
     * @param callable $callback The condition callback
     * @return array Array with 'true' and 'false' keys
     */
    function array_partition(array $array, callable $callback): array
    {
        $result = ['true' => [], 'false' => []];
        
        foreach ($array as $key => $value) {
            $condition = $callback($value, $key);
            $result[$condition ? 'true' : 'false'][$key] = $value;
        }
        
        return $result;
    }
}

if (!function_exists('array_is_assoc')) {
    /**
     * Check if array is associative
     * 
     * @param array $array The array to check
     * @return bool True if associative
     */
    function array_is_assoc(array $array): bool
    {
        if (empty($array)) {
            return false;
        }
        
        return array_keys($array) !== range(0, count($array) - 1);
    }
}

if (!function_exists('array_is_list')) {
    /**
     * Check if array is sequential (list)
     * 
     * @param array $array The array to check
     * @return bool True if sequential
     */
    function array_is_list(array $array): bool
    {
        if (empty($array)) {
            return true;
        }
        
        return array_keys($array) === range(0, count($array) - 1);
    }
}

if (!function_exists('array_only_keys')) {
    /**
     * Filter only specific keys
     * 
     * @param array $array The array to filter
     * @param array $keys The keys to keep
     * @return array Filtered array
     */
    function array_only_keys(array $array, array $keys): array
    {
        return array_intersect_key($array, array_flip($keys));
    }
}

if (!function_exists('array_except_keys')) {
    /**
     * Exclude specific keys
     * 
     * @param array $array The array to filter
     * @param array $keys The keys to exclude
     * @return array Filtered array
     */
    function array_except_keys(array $array, array $keys): array
    {
        return array_diff_key($array, array_flip($keys));
    }
}

if (!function_exists('array_merge_recursive_distinct')) {
    /**
     * Merge arrays recursively without overwriting
     * 
     * @param array $array1 First array
     * @param array $array2 Second array
     * @return array Merged array
     */
    function array_merge_recursive_distinct(array $array1, array $array2): array
    {
        $merged = $array1;
        
        foreach ($array2 as $key => $value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = array_merge_recursive_distinct($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }
        
        return $merged;
    }
}

if (!function_exists('array_diff_recursive')) {
    /**
     * Recursive array difference
     * 
     * @param array $array1 First array
     * @param array $array2 Second array
     * @return array Difference array
     */
    function array_diff_recursive(array $array1, array $array2): array
    {
        $diff = [];
        
        foreach ($array1 as $key => $value) {
            if (!array_key_exists($key, $array2)) {
                $diff[$key] = $value;
            } elseif (is_array($value) && is_array($array2[$key])) {
                $recursiveDiff = array_diff_recursive($value, $array2[$key]);
                if (!empty($recursiveDiff)) {
                    $diff[$key] = $recursiveDiff;
                }
            } elseif ($value !== $array2[$key]) {
                $diff[$key] = $value;
            }
        }
        
        return $diff;
    }
}

if (!function_exists('array_to_csv')) {
    /**
     * Converts array to CSV string
     * 
     * @param array $array The array to convert
     * @param string $delimiter CSV delimiter
     * @param string $enclosure CSV enclosure
     * @return string CSV string
     */
    function array_to_csv(array $array, string $delimiter = ',', string $enclosure = '"'): string
    {
        if (empty($array)) {
            return '';
        }
        
        $output = fopen('php://temp', 'r+');
        
        // Add headers if first row is associative
        if (array_is_assoc($array[0] ?? [])) {
            fputcsv($output, array_keys($array[0]), $delimiter, $enclosure);
        }
        
        foreach ($array as $row) {
            fputcsv($output, $row, $delimiter, $enclosure);
        }
        
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);
        
        return $csv;
    }
}

if (!function_exists('array_from_csv')) {
    /**
     * Parse CSV string to array
     * 
     * @param string $csv The CSV string
     * @param string $delimiter CSV delimiter
     * @param string $enclosure CSV enclosure
     * @return array Parsed array
     */
    function array_from_csv(string $csv, string $delimiter = ',', string $enclosure = '"'): array
    {
        if (empty($csv)) {
            return [];
        }
        
        $lines = str_getcsv($csv, "\n");
        $result = [];
        
        foreach ($lines as $line) {
            $result[] = str_getcsv($line, $delimiter, $enclosure);
        }
        
        return $result;
    }
}

if (!function_exists('array_split_chunks')) {
    /**
     * Splits array into chunks
     * 
     * @param array $array The array to split
     * @param int $size Chunk size
     * @return array Array of chunks
     */
    function array_split_chunks(array $array, int $size): array
    {
        return array_chunk($array, $size);
    }
}

if (!function_exists('array_pad_left')) {
    /**
     * Pad array from left
     * 
     * @param array $array The array to pad
     * @param int $size Target size
     * @param mixed $value Padding value
     * @return array Padded array
     */
    function array_pad_left(array $array, int $size, $value = null): array
    {
        $currentSize = count($array);
        if ($currentSize >= $size) {
            return $array;
        }
        
        $padCount = $size - $currentSize;
        return array_merge(array_fill(0, $padCount, $value), $array);
    }
}

if (!function_exists('array_pad_right')) {
    /**
     * Pad array from right
     * 
     * @param array $array The array to pad
     * @param int $size Target size
     * @param mixed $value Padding value
     * @return array Padded array
     */
    function array_pad_right(array $array, int $size, $value = null): array
    {
        $currentSize = count($array);
        if ($currentSize >= $size) {
            return $array;
        }
        
        $padCount = $size - $currentSize;
        return array_merge($array, array_fill(0, $padCount, $value));
    }
}

if (!function_exists('array_to_collection')) {
    /**
     * Convert array to Laravel collection
     * 
     * @param array $array The array to convert
     * @return \Illuminate\Support\Collection Laravel collection
     */
    function array_to_collection(array $array): \Illuminate\Support\Collection
    {
        return collect($array);
    }
}

if (!function_exists('array_random_subset')) {
    /**
     * Pick random N items from array
     * 
     * @param array $array The array to pick from
     * @param int $count Number of items to pick
     * @return array Random subset
     */
    function array_random_subset(array $array, int $count): array
    {
        if ($count >= count($array)) {
            return $array;
        }
        
        $keys = array_rand($array, $count);
        if (!is_array($keys)) {
            $keys = [$keys];
        }
        
        return array_intersect_key($array, array_flip($keys));
    }
}

if (!function_exists('array_to_object')) {
    /**
     * Convert array to object
     * 
     * @param array $array The array to convert
     * @return object Converted object
     */
    function array_to_object(array $array): object
    {
        return (object) $array;
    }
}
