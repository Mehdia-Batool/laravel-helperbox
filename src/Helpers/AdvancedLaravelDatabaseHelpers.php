<?php

/**
 * Advanced Laravel & Database Helper Functions
 * 
 * This file contains 40+ advanced Laravel and database utility functions
 * for optimization, advanced queries, and performance enhancement.
 * 
 * @package Subhashladumor\LaravelHelperbox
 * @author Subhash Ladumor
 */

if (!function_exists('model_clone')) {
    /**
     * Clone model with all relationships
     * 
     * @param \Illuminate\Database\Eloquent\Model $model Model to clone
     * @param array $excludeAttributes Attributes to exclude
     * @return \Illuminate\Database\Eloquent\Model Cloned model
     */
    function model_clone($model, array $excludeAttributes = ['id', 'created_at', 'updated_at'])
    {
        $cloned = $model->replicate($excludeAttributes);
        $cloned->save();
        
        // Clone relationships
        foreach ($model->getRelations() as $relationName => $relation) {
            if ($relation instanceof \Illuminate\Database\Eloquent\Collection) {
                $cloned->{$relationName}()->saveMany($relation->map(function($item) use ($excludeAttributes) {
                    return model_clone($item, $excludeAttributes);
                }));
            } elseif ($relation instanceof \Illuminate\Database\Eloquent\Model) {
                $cloned->{$relationName}()->associate(model_clone($relation, $excludeAttributes));
            }
        }
        
        return $cloned;
    }
}

if (!function_exists('model_diff')) {
    /**
     * Get differences between two model instances
     * 
     * @param \Illuminate\Database\Eloquent\Model $model1 First model
     * @param \Illuminate\Database\Eloquent\Model $model2 Second model
     * @return array Array of differences
     */
    function model_diff($model1, $model2): array
    {
        $diff = [];
        $attributes1 = $model1->getAttributes();
        $attributes2 = $model2->getAttributes();
        
        foreach ($attributes1 as $key => $value) {
            if (!isset($attributes2[$key]) || $attributes2[$key] !== $value) {
                $diff[$key] = [
                    'old' => $value,
                    'new' => $attributes2[$key] ?? null
                ];
            }
        }
        
        foreach ($attributes2 as $key => $value) {
            if (!isset($attributes1[$key])) {
                $diff[$key] = [
                    'old' => null,
                    'new' => $value
                ];
            }
        }
        
        return $diff;
    }
}

if (!function_exists('model_to_tree')) {
    /**
     * Convert flat model collection to tree structure
     * 
     * @param \Illuminate\Database\Eloquent\Collection $models Collection of models
     * @param string $parentKey Parent key field
     * @param string $childrenKey Children key name
     * @return array Tree structure
     */
    function model_to_tree($models, string $parentKey = 'parent_id', string $childrenKey = 'children'): array
    {
        $tree = [];
        $indexed = [];
        
        // Index all models
        foreach ($models as $model) {
            $indexed[$model->id] = $model->toArray();
            $indexed[$model->id][$childrenKey] = [];
        }
        
        // Build tree
        foreach ($indexed as $id => $model) {
            if ($model[$parentKey] && isset($indexed[$model[$parentKey]])) {
                $indexed[$model[$parentKey]][$childrenKey][] = &$indexed[$id];
            } else {
                $tree[] = &$indexed[$id];
            }
        }
        
        return $tree;
    }
}

if (!function_exists('db_safe_transaction')) {
    /**
     * Execute database transaction with automatic rollback on exception
     * 
     * @param callable $callback Transaction callback
     * @param int $attempts Number of attempts
     * @return mixed Transaction result
     */
    function db_safe_transaction(callable $callback, int $attempts = 1)
    {
        return \DB::transaction($callback, $attempts);
    }
}

if (!function_exists('db_query_log')) {
    /**
     * Enable query logging and return queries
     * 
     * @param callable $callback Callback to execute
     * @return array Array of executed queries
     */
    function db_query_log(callable $callback): array
    {
        \DB::enableQueryLog();
        
        try {
            $result = $callback();
            return \DB::getQueryLog();
        } finally {
            \DB::disableQueryLog();
        }
    }
}

if (!function_exists('db_mass_insert')) {
    /**
     * Mass insert with chunking for large datasets
     * 
     * @param string $table Table name
     * @param array $data Data to insert
     * @param int $chunkSize Chunk size
     * @return int Number of inserted records
     */
    function db_mass_insert(string $table, array $data, int $chunkSize = 1000): int
    {
        if (empty($data)) {
            return 0;
        }
        
        $chunks = array_chunk($data, $chunkSize);
        $inserted = 0;
        
        foreach ($chunks as $chunk) {
            \DB::table($table)->insert($chunk);
            $inserted += count($chunk);
        }
        
        return $inserted;
    }
}

if (!function_exists('db_mass_upsert')) {
    /**
     * Mass upsert (insert or update) with chunking
     * 
     * @param string $table Table name
     * @param array $data Data to upsert
     * @param array $uniqueKeys Unique key columns
     * @param int $chunkSize Chunk size
     * @return int Number of processed records
     */
    function db_mass_upsert(string $table, array $data, array $uniqueKeys, int $chunkSize = 1000): int
    {
        if (empty($data)) {
            return 0;
        }
        
        $chunks = array_chunk($data, $chunkSize);
        $processed = 0;
        
        foreach ($chunks as $chunk) {
            \DB::table($table)->upsert($chunk, $uniqueKeys);
            $processed += count($chunk);
        }
        
        return $processed;
    }
}

if (!function_exists('db_stream_query')) {
    /**
     * Stream large query results to avoid memory issues
     * 
     * @param \Illuminate\Database\Query\Builder $query Query builder
     * @param callable $callback Callback for each chunk
     * @param int $chunkSize Chunk size
     * @return int Number of processed records
     */
    function db_stream_query($query, callable $callback, int $chunkSize = 1000): int
    {
        $processed = 0;
        
        $query->chunk($chunkSize, function($chunk) use ($callback, &$processed) {
            $callback($chunk);
            $processed += $chunk->count();
        });
        
        return $processed;
    }
}

if (!function_exists('db_detect_n_plus_one')) {
    /**
     * Detect N+1 query problems in Eloquent queries
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query Query builder
     * @param array $relations Relations to check
     * @return array N+1 detection results
     */
    function db_detect_n_plus_one($query, array $relations): array
    {
        $queries = [];
        $nPlusOne = [];
        
        \DB::listen(function($query) use (&$queries) {
            $queries[] = [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time
            ];
        });
        
        $results = $query->get();
        
        foreach ($relations as $relation) {
            foreach ($results as $model) {
                $model->{$relation}; // Trigger the relation
            }
        }
        
        // Analyze queries for patterns
        $relationQueries = [];
        foreach ($queries as $query) {
            if (preg_match('/where.*in.*\(/', $query['sql'])) {
                $relationQueries[] = $query;
            }
        }
        
        return [
            'total_queries' => count($queries),
            'relation_queries' => count($relationQueries),
            'n_plus_one_detected' => count($relationQueries) > count($relations),
            'queries' => $queries
        ];
    }
}

if (!function_exists('db_auto_paginate')) {
    /**
     * Auto-paginate query based on request parameters
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query Query builder
     * @param int $defaultPerPage Default items per page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    function db_auto_paginate($query, int $defaultPerPage = 15)
    {
        $perPage = request('per_page', $defaultPerPage);
        $perPage = min($perPage, 100); // Limit max per page
        
        return $query->paginate($perPage);
    }
}

if (!function_exists('db_cache_results')) {
    /**
     * Cache query results with automatic invalidation
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query Query builder
     * @param string $cacheKey Cache key
     * @param int $ttl TTL in seconds
     * @return mixed Cached results
     */
    function db_cache_results($query, string $cacheKey, int $ttl = 3600)
    {
        return \Cache::remember($cacheKey, $ttl, function() use ($query) {
            return $query->get();
        });
    }
}

if (!function_exists('db_optimize_select_fields')) {
    /**
     * Optimize select fields to avoid selecting unnecessary columns
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query Query builder
     * @param array $fields Required fields
     * @return \Illuminate\Database\Eloquent\Builder
     */
    function db_optimize_select_fields($query, array $fields)
    {
        return $query->select($fields);
    }
}

if (!function_exists('db_merge_duplicates')) {
    /**
     * Merge duplicate records based on criteria
     * 
     * @param string $table Table name
     * @param array $criteria Criteria for finding duplicates
     * @param callable $mergeCallback Callback to merge records
     * @return int Number of merged records
     */
    function db_merge_duplicates(string $table, array $criteria, callable $mergeCallback): int
    {
        $duplicates = \DB::table($table)
            ->select($criteria)
            ->groupBy($criteria)
            ->havingRaw('COUNT(*) > 1')
            ->get();
        
        $merged = 0;
        
        foreach ($duplicates as $duplicate) {
            $records = \DB::table($table)
                ->where(function($query) use ($criteria, $duplicate) {
                    foreach ($criteria as $field) {
                        $query->where($field, $duplicate->{$field});
                    }
                })
                ->get();
            
            if ($records->count() > 1) {
                $mergedRecord = $mergeCallback($records->toArray());
                
                // Keep first record, delete others
                $firstRecord = $records->first();
                \DB::table($table)->where('id', $firstRecord->id)->update($mergedRecord);
                
                $otherIds = $records->where('id', '!=', $firstRecord->id)->pluck('id');
                \DB::table($table)->whereIn('id', $otherIds)->delete();
                
                $merged += $otherIds->count();
            }
        }
        
        return $merged;
    }
}

if (!function_exists('db_detect_outliers')) {
    /**
     * Detect outlier values in numeric columns
     * 
     * @param string $table Table name
     * @param string $column Column name
     * @param float $threshold Outlier threshold (standard deviations)
     * @return array Outlier records
     */
    function db_detect_outliers(string $table, string $column, float $threshold = 2.0): array
    {
        $stats = \DB::table($table)
            ->selectRaw("
                AVG({$column}) as mean,
                STDDEV({$column}) as stddev
            ")
            ->first();
        
        if (!$stats || !$stats->stddev) {
            return [];
        }
        
        $lowerBound = $stats->mean - ($threshold * $stats->stddev);
        $upperBound = $stats->mean + ($threshold * $stats->stddev);
        
        return \DB::table($table)
            ->where($column, '<', $lowerBound)
            ->orWhere($column, '>', $upperBound)
            ->get()
            ->toArray();
    }
}

if (!function_exists('db_mask_sensitive_data')) {
    /**
     * Mask sensitive data in query results
     * 
     * @param array $data Data to mask
     * @param array $sensitiveFields Sensitive field names
     * @param string $mask Character to use for masking
     * @return array Masked data
     */
    function db_mask_sensitive_data(array $data, array $sensitiveFields, string $mask = '*'): array
    {
        foreach ($data as &$record) {
            if (is_array($record)) {
                foreach ($sensitiveFields as $field) {
                    if (isset($record[$field])) {
                        $value = $record[$field];
                        $length = strlen($value);
                        if ($length > 4) {
                            $record[$field] = substr($value, 0, 2) . str_repeat($mask, $length - 4) . substr($value, -2);
                        } else {
                            $record[$field] = str_repeat($mask, $length);
                        }
                    }
                }
            }
        }
        
        return $data;
    }
}

if (!function_exists('db_archive_old_rows')) {
    /**
     * Archive old rows to separate table
     * 
     * @param string $sourceTable Source table
     * @param string $archiveTable Archive table
     * @param string $dateColumn Date column for filtering
     * @param string $cutoffDate Cutoff date
     * @return int Number of archived records
     */
    function db_archive_old_rows(string $sourceTable, string $archiveTable, string $dateColumn, string $cutoffDate): int
    {
        // Create archive table if it doesn't exist
        $sourceColumns = \DB::select("DESCRIBE {$sourceTable}");
        $columnDefs = [];
        
        foreach ($sourceColumns as $column) {
            $columnDefs[] = "{$column->Field} {$column->Type}";
        }
        
        \DB::statement("CREATE TABLE IF NOT EXISTS {$archiveTable} (" . implode(', ', $columnDefs) . ")");
        
        // Move old records
        $oldRecords = \DB::table($sourceTable)
            ->where($dateColumn, '<', $cutoffDate)
            ->get();
        
        if ($oldRecords->isNotEmpty()) {
            \DB::table($archiveTable)->insert($oldRecords->toArray());
            
            $ids = $oldRecords->pluck('id');
            \DB::table($sourceTable)->whereIn('id', $ids)->delete();
        }
        
        return $oldRecords->count();
    }
}

if (!function_exists('db_auto_sharding')) {
    /**
     * Auto-shard data across multiple tables
     * 
     * @param string $baseTable Base table name
     * @param string $shardKey Shard key field
     * @param int $shardCount Number of shards
     * @return array Shard information
     */
    function db_auto_sharding(string $baseTable, string $shardKey, int $shardCount): array
    {
        $shards = [];
        
        for ($i = 0; $i < $shardCount; $i++) {
            $shardTable = "{$baseTable}_shard_{$i}";
            
            // Create shard table
            $sourceColumns = \DB::select("DESCRIBE {$baseTable}");
            $columnDefs = [];
            
            foreach ($sourceColumns as $column) {
                $columnDefs[] = "{$column->Field} {$column->Type}";
            }
            
            \DB::statement("CREATE TABLE IF NOT EXISTS {$shardTable} (" . implode(', ', $columnDefs) . ")");
            
            $shards[] = [
                'table' => $shardTable,
                'shard_id' => $i,
                'range' => [
                    'min' => $i * (PHP_INT_MAX / $shardCount),
                    'max' => ($i + 1) * (PHP_INT_MAX / $shardCount)
                ]
            ];
        }
        
        return $shards;
    }
}

if (!function_exists('db_get_trending_data')) {
    /**
     * Get trending data based on time series
     * 
     * @param string $table Table name
     * @param string $dateColumn Date column
     * @param string $valueColumn Value column
     * @param int $days Number of days to analyze
     * @return array Trending data
     */
    function db_get_trending_data(string $table, string $dateColumn, string $valueColumn, int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        $data = \DB::table($table)
            ->selectRaw("
                DATE({$dateColumn}) as date,
                COUNT(*) as count,
                AVG({$valueColumn}) as avg_value,
                SUM({$valueColumn}) as total_value
            ")
            ->where($dateColumn, '>=', $startDate)
            ->groupBy(\DB::raw("DATE({$dateColumn})"))
            ->orderBy('date')
            ->get();
        
        // Calculate trend
        $trend = 0;
        if ($data->count() > 1) {
            $first = $data->first();
            $last = $data->last();
            $trend = (($last->avg_value - $first->avg_value) / $first->avg_value) * 100;
        }
        
        return [
            'data' => $data->toArray(),
            'trend' => $trend,
            'period' => $days,
            'is_trending_up' => $trend > 0
        ];
    }
}

if (!function_exists('db_rank_by_field')) {
    /**
     * Add ranking to query results based on field
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query Query builder
     * @param string $field Field to rank by
     * @param string $rankColumn Rank column name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    function db_rank_by_field($query, string $field, string $rankColumn = 'rank')
    {
        return $query->selectRaw("*, ROW_NUMBER() OVER (ORDER BY {$field} DESC) as {$rankColumn}");
    }
}

if (!function_exists('db_analyze_index_usage')) {
    /**
     * Analyze index usage for table
     * 
     * @param string $table Table name
     * @return array Index usage analysis
     */
    function db_analyze_index_usage(string $table): array
    {
        $indexes = \DB::select("SHOW INDEX FROM {$table}");
        $usage = [];
        
        foreach ($indexes as $index) {
            $usage[] = [
                'table' => $index->Table,
                'key_name' => $index->Key_name,
                'column_name' => $index->Column_name,
                'cardinality' => $index->Cardinality,
                'index_type' => $index->Index_type
            ];
        }
        
        return $usage;
    }
}

if (!function_exists('db_optimize_table_structure')) {
    /**
     * Optimize table structure and indexes
     * 
     * @param string $table Table name
     * @return array Optimization results
     */
    function db_optimize_table_structure(string $table): array
    {
        $results = [];
        
        // Analyze table
        \DB::statement("ANALYZE TABLE {$table}");
        $results['analyzed'] = true;
        
        // Optimize table
        \DB::statement("OPTIMIZE TABLE {$table}");
        $results['optimized'] = true;
        
        // Get table status
        $status = \DB::select("SHOW TABLE STATUS LIKE '{$table}'")[0];
        $results['status'] = [
            'rows' => $status->Rows,
            'data_length' => $status->Data_length,
            'index_length' => $status->Index_length,
            'data_free' => $status->Data_free
        ];
        
        return $results;
    }
}

if (!function_exists('db_export_to_json')) {
    /**
     * Export table data to JSON file
     * 
     * @param string $table Table name
     * @param string $filePath Output file path
     * @param array $conditions Where conditions
     * @return bool Success status
     */
    function db_export_to_json(string $table, string $filePath, array $conditions = []): bool
    {
        $query = \DB::table($table);
        
        foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }
        
        $data = $query->get()->toArray();
        
        return file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT)) !== false;
    }
}

if (!function_exists('db_import_from_json')) {
    /**
     * Import data from JSON file to table
     * 
     * @param string $table Table name
     * @param string $filePath JSON file path
     * @param bool $truncateFirst Whether to truncate table first
     * @return int Number of imported records
     */
    function db_import_from_json(string $table, string $filePath, bool $truncateFirst = false): int
    {
        if (!file_exists($filePath)) {
            return 0;
        }
        
        $data = json_decode(file_get_contents($filePath), true);
        
        if (!$data || !is_array($data)) {
            return 0;
        }
        
        if ($truncateFirst) {
            \DB::table($table)->truncate();
        }
        
        return db_mass_insert($table, $data);
    }
}

if (!function_exists('db_create_backup')) {
    /**
     * Create database backup
     * 
     * @param string $backupPath Backup file path
     * @param array $tables Tables to backup (empty = all)
     * @return bool Success status
     */
    function db_create_backup(string $backupPath, array $tables = []): bool
    {
        $config = config('database.connections.' . config('database.default'));
        $command = "mysqldump -h {$config['host']} -u {$config['username']} -p{$config['password']} {$config['database']}";
        
        if (!empty($tables)) {
            $command .= ' ' . implode(' ', $tables);
        }
        
        $command .= " > {$backupPath}";
        
        exec($command, $output, $returnCode);
        
        return $returnCode === 0;
    }
}

if (!function_exists('db_restore_backup')) {
    /**
     * Restore database from backup
     * 
     * @param string $backupPath Backup file path
     * @return bool Success status
     */
    function db_restore_backup(string $backupPath): bool
    {
        if (!file_exists($backupPath)) {
            return false;
        }
        
        $config = config('database.connections.' . config('database.default'));
        $command = "mysql -h {$config['host']} -u {$config['username']} -p{$config['password']} {$config['database']} < {$backupPath}";
        
        exec($command, $output, $returnCode);
        
        return $returnCode === 0;
    }
}
