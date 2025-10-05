<?php

/**
 * Model & Database Helper Functions
 * 
 * This file contains 30+ advanced Eloquent and database utility functions
 * for model operations, database queries, and data management.
 * 
 * @package Subhashladumor\LaravelHelperbox
 * @author Subhash Ladumor
 */

if (!function_exists('model_exists')) {
    /**
     * Check if model record exists
     * 
     * @param string $model Model class name
     * @param mixed $id Record ID
     * @return bool True if record exists
     */
    function model_exists(string $model, $id): bool
    {
        try {
            return $model::where('id', $id)->exists();
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('model_find_or_log')) {
    /**
     * Find model or log missing record
     * 
     * @param string $model Model class name
     * @param mixed $id Record ID
     * @return mixed Model instance or null
     */
    function model_find_or_log(string $model, $id)
    {
        try {
            $record = $model::find($id);
            
            if (!$record) {
                \Log::warning("Model {$model} with ID {$id} not found");
            }
            
            return $record;
        } catch (Exception $e) {
            \Log::error("Error finding model {$model} with ID {$id}: " . $e->getMessage());
            return null;
        }
    }
}

if (!function_exists('model_count')) {
    /**
     * Count model records with conditions
     * 
     * @param string $model Model class name
     * @param array $conditions Where conditions
     * @return int Record count
     */
    function model_count(string $model, array $conditions = []): int
    {
        try {
            $query = $model::query();
            
            foreach ($conditions as $field => $value) {
                if (is_array($value)) {
                    $query->whereIn($field, $value);
                } else {
                    $query->where($field, $value);
                }
            }
            
            return $query->count();
        } catch (Exception $e) {
            return 0;
        }
    }
}

if (!function_exists('model_random')) {
    /**
     * Get random model record
     * 
     * @param string $model Model class name
     * @param array $conditions Where conditions
     * @return mixed Random model instance or null
     */
    function model_random(string $model, array $conditions = [])
    {
        try {
            $query = $model::query();
            
            foreach ($conditions as $field => $value) {
                if (is_array($value)) {
                    $query->whereIn($field, $value);
                } else {
                    $query->where($field, $value);
                }
            }
            
            return $query->inRandomOrder()->first();
        } catch (Exception $e) {
            return null;
        }
    }
}

if (!function_exists('model_soft_delete')) {
    /**
     * Soft delete model record
     * 
     * @param string $model Model class name
     * @param mixed $id Record ID
     * @return bool True if deleted
     */
    function model_soft_delete(string $model, $id): bool
    {
        try {
            $record = $model::find($id);
            
            if (!$record) {
                return false;
            }
            
            if (method_exists($record, 'delete')) {
                $record->delete();
                return true;
            }
            
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('db_is_table')) {
    /**
     * Check if database table exists
     * 
     * @param string $table Table name
     * @return bool True if table exists
     */
    function db_is_table(string $table): bool
    {
        try {
            return \Schema::hasTable($table);
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('db_is_column')) {
    /**
     * Check if table column exists
     * 
     * @param string $table Table name
     * @param string $column Column name
     * @return bool True if column exists
     */
    function db_is_column(string $table, string $column): bool
    {
        try {
            return \Schema::hasColumn($table, $column);
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('db_table_size')) {
    /**
     * Get table size in bytes
     * 
     * @param string $table Table name
     * @return int Table size in bytes
     */
    function db_table_size(string $table): int
    {
        try {
            $result = \DB::select("
                SELECT 
                    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'Size_MB'
                FROM information_schema.TABLES 
                WHERE table_schema = DATABASE()
                AND table_name = ?
            ", [$table]);
            
            return isset($result[0]) ? (int)($result[0]->Size_MB * 1024 * 1024) : 0;
        } catch (Exception $e) {
            return 0;
        }
    }
}

if (!function_exists('db_last_query')) {
    /**
     * Get last executed query
     * 
     * @return string Last SQL query
     */
    function db_last_query(): string
    {
        $queries = \DB::getQueryLog();
        return end($queries)['query'] ?? '';
    }
}

if (!function_exists('db_to_csv')) {
    /**
     * Export query result to CSV
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query Query builder
     * @param string $path Output file path
     * @return bool True if successful
     */
    function db_to_csv($query, string $path): bool
    {
        try {
            $results = $query->get()->toArray();
            
            if (empty($results)) {
                return false;
            }
            
            $file = fopen($path, 'w');
            
            // Write headers
            fputcsv($file, array_keys($results[0]));
            
            // Write data
            foreach ($results as $row) {
                fputcsv($file, $row);
            }
            
            fclose($file);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('db_seed_random')) {
    /**
     * Insert dummy data into table
     * 
     * @param string $table Table name
     * @param int $count Number of records to insert
     * @param array $data Data template
     * @return int Number of inserted records
     */
    function db_seed_random(string $table, int $count, array $data = []): int
    {
        try {
            $records = [];
            
            for ($i = 0; $i < $count; $i++) {
                $record = [];
                foreach ($data as $field => $value) {
                    if (is_callable($value)) {
                        $record[$field] = $value();
                    } else {
                        $record[$field] = $value;
                    }
                }
                $records[] = $record;
            }
            
            return \DB::table($table)->insert($records) ? $count : 0;
        } catch (Exception $e) {
            return 0;
        }
    }
}

if (!function_exists('db_copy_table')) {
    /**
     * Copy table structure and data
     * 
     * @param string $from Source table
     * @param string $to Destination table
     * @return bool True if successful
     */
    function db_copy_table(string $from, string $to): bool
    {
        try {
            // Copy structure
            \DB::statement("CREATE TABLE {$to} LIKE {$from}");
            
            // Copy data
            \DB::statement("INSERT INTO {$to} SELECT * FROM {$from}");
            
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('db_truncate_cascade')) {
    /**
     * Truncate table with foreign key constraints
     * 
     * @param string $table Table name
     * @return bool True if successful
     */
    function db_truncate_cascade(string $table): bool
    {
        try {
            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            \DB::table($table)->truncate();
            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('db_transaction_safe')) {
    /**
     * Run callback inside safe transaction
     * 
     * @param callable $callback Callback to execute
     * @return mixed Callback result
     */
    function db_transaction_safe(callable $callback)
    {
        try {
            return \DB::transaction($callback);
        } catch (Exception $e) {
            \Log::error('Transaction failed: ' . $e->getMessage());
            return null;
        }
    }
}

if (!function_exists('db_lock_table')) {
    /**
     * Lock table for writing
     * 
     * @param string $table Table name
     * @return bool True if successful
     */
    function db_lock_table(string $table): bool
    {
        try {
            \DB::statement("LOCK TABLES {$table} WRITE");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('db_unlock_table')) {
    /**
     * Unlock all tables
     * 
     * @return bool True if successful
     */
    function db_unlock_table(): bool
    {
        try {
            \DB::statement('UNLOCK TABLES');
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('db_column_type')) {
    /**
     * Get column data type
     * 
     * @param string $table Table name
     * @param string $column Column name
     * @return string Column type
     */
    function db_column_type(string $table, string $column): string
    {
        try {
            $result = \DB::select("
                SELECT DATA_TYPE 
                FROM INFORMATION_SCHEMA.COLUMNS 
                WHERE TABLE_NAME = ? AND COLUMN_NAME = ?
            ", [$table, $column]);
            
            return $result[0]->DATA_TYPE ?? '';
        } catch (Exception $e) {
            return '';
        }
    }
}

if (!function_exists('db_list_tables')) {
    /**
     * List all database tables
     * 
     * @return array Array of table names
     */
    function db_list_tables(): array
    {
        try {
            $tables = \DB::select('SHOW TABLES');
            $tableName = 'Tables_in_' . \DB::getDatabaseName();
            
            return array_map(function($table) use ($tableName) {
                return $table->$tableName;
            }, $tables);
        } catch (Exception $e) {
            return [];
        }
    }
}

if (!function_exists('db_list_columns')) {
    /**
     * List table columns
     * 
     * @param string $table Table name
     * @return array Array of column information
     */
    function db_list_columns(string $table): array
    {
        try {
            return \DB::select("DESCRIBE {$table}");
        } catch (Exception $e) {
            return [];
        }
    }
}

if (!function_exists('db_list_indexes')) {
    /**
     * List table indexes
     * 
     * @param string $table Table name
     * @return array Array of index information
     */
    function db_list_indexes(string $table): array
    {
        try {
            return \DB::select("SHOW INDEX FROM {$table}");
        } catch (Exception $e) {
            return [];
        }
    }
}

if (!function_exists('model_bulk_update')) {
    /**
     * Bulk update model records
     * 
     * @param string $model Model class name
     * @param array $updates Array of updates with IDs
     * @return int Number of updated records
     */
    function model_bulk_update(string $model, array $updates): int
    {
        try {
            $updated = 0;
            
            foreach ($updates as $id => $data) {
                if ($model::where('id', $id)->update($data)) {
                    $updated++;
                }
            }
            
            return $updated;
        } catch (Exception $e) {
            return 0;
        }
    }
}

if (!function_exists('model_bulk_insert')) {
    /**
     * Bulk insert model records
     * 
     * @param string $model Model class name
     * @param array $data Array of data to insert
     * @return int Number of inserted records
     */
    function model_bulk_insert(string $model, array $data): int
    {
        try {
            return $model::insert($data) ? count($data) : 0;
        } catch (Exception $e) {
            return 0;
        }
    }
}

if (!function_exists('model_upsert')) {
    /**
     * Insert or update model record
     * 
     * @param string $model Model class name
     * @param array $data Data to insert/update
     * @param array $uniqueKeys Unique keys for conflict resolution
     * @return bool True if successful
     */
    function model_upsert(string $model, array $data, array $uniqueKeys = ['id']): bool
    {
        try {
            return $model::upsert($data, $uniqueKeys) > 0;
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('model_soft_restore')) {
    /**
     * Restore soft deleted model record
     * 
     * @param string $model Model class name
     * @param mixed $id Record ID
     * @return bool True if restored
     */
    function model_soft_restore(string $model, $id): bool
    {
        try {
            $record = $model::withTrashed()->find($id);
            
            if (!$record || !$record->trashed()) {
                return false;
            }
            
            return $record->restore();
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('model_force_delete')) {
    /**
     * Force delete model record (permanent)
     * 
     * @param string $model Model class name
     * @param mixed $id Record ID
     * @return bool True if deleted
     */
    function model_force_delete(string $model, $id): bool
    {
        try {
            $record = $model::withTrashed()->find($id);
            
            if (!$record) {
                return false;
            }
            
            return $record->forceDelete();
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('model_scope_exists')) {
    /**
     * Check if model scope exists
     * 
     * @param string $model Model class name
     * @param string $scope Scope name
     * @return bool True if scope exists
     */
    function model_scope_exists(string $model, string $scope): bool
    {
        try {
            $reflection = new ReflectionClass($model);
            return $reflection->hasMethod('scope' . ucfirst($scope));
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('model_relationship_exists')) {
    /**
     * Check if model relationship exists
     * 
     * @param string $model Model class name
     * @param string $relationship Relationship name
     * @return bool True if relationship exists
     */
    function model_relationship_exists(string $model, string $relationship): bool
    {
        try {
            $reflection = new ReflectionClass($model);
            return $reflection->hasMethod($relationship);
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('db_optimize_table')) {
    /**
     * Optimize database table
     * 
     * @param string $table Table name
     * @return bool True if successful
     */
    function db_optimize_table(string $table): bool
    {
        try {
            \DB::statement("OPTIMIZE TABLE {$table}");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('db_repair_table')) {
    /**
     * Repair database table
     * 
     * @param string $table Table name
     * @return bool True if successful
     */
    function db_repair_table(string $table): bool
    {
        try {
            \DB::statement("REPAIR TABLE {$table}");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('db_analyze_table')) {
    /**
     * Analyze database table
     * 
     * @param string $table Table name
     * @return bool True if successful
     */
    function db_analyze_table(string $table): bool
    {
        try {
            \DB::statement("ANALYZE TABLE {$table}");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('db_check_table')) {
    /**
     * Check database table integrity
     * 
     * @param string $table Table name
     * @return bool True if table is OK
     */
    function db_check_table(string $table): bool
    {
        try {
            $result = \DB::select("CHECK TABLE {$table}");
            return isset($result[0]) && $result[0]->Msg_text === 'OK';
        } catch (Exception $e) {
            return false;
        }
    }
}
