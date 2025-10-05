### AdvancedLaravelDatabaseHelpers

High-level DB/Eloquent utilities: cloning, diffing, chunking, upserts, N+1 detection, backups, trends, ranking, and optimization.

#### Function Index

- model_clone($model, array $excludeAttributes = ['id','created_at','updated_at'])
- model_diff($model1, $model2): array
- model_to_tree($models, string $parentKey = 'parent_id', string $childrenKey = 'children'): array
- db_safe_transaction(callable $callback, int $attempts = 1)
- db_query_log(callable $callback): array
- db_mass_insert(string $table, array $data, int $chunkSize = 1000): int
- db_mass_upsert(string $table, array $data, array $uniqueKeys, int $chunkSize = 1000): int
- db_stream_query($query, callable $callback, int $chunkSize = 1000): int
- db_detect_n_plus_one($query, array $relations): array
- db_auto_paginate($query, int $defaultPerPage = 15)
- db_cache_results($query, string $cacheKey, int $ttl = 3600)
- db_optimize_select_fields($query, array $fields)
- db_merge_duplicates(string $table, array $criteria, callable $mergeCallback): int
- db_detect_outliers(string $table, string $column, float $threshold = 2.0): array
- db_mask_sensitive_data(array $data, array $sensitiveFields, string $mask = '*'): array
- db_archive_old_rows(string $sourceTable, string $archiveTable, string $dateColumn, string $cutoffDate): int
- db_auto_sharding(string $baseTable, string $shardKey, int $shardCount): array
- db_get_trending_data(string $table, string $dateColumn, string $valueColumn, int $days = 30): array
- db_rank_by_field($query, string $field, string $rankColumn = 'rank')
- db_analyze_index_usage(string $table): array
- db_optimize_table_structure(string $table): array
- db_export_to_json(string $table, string $filePath, array $conditions = []): bool
- db_import_from_json(string $table, string $filePath, bool $truncateFirst = false): int
- db_create_backup(string $backupPath, array $tables = []): bool
- db_restore_backup(string $backupPath): bool


