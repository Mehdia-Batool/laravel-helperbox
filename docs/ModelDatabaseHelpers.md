### ModelDatabaseHelpers

Focused Eloquent/DB helpers for existence checks, counts, randoms, CSV export, seeding, locks, schema checks, and table maintenance.

#### Function Index

- model_exists(string $model, mixed $id): bool
- model_find_or_log(string $model, mixed $id)
- model_count(string $model, array $conditions = []): int
- model_random(string $model, array $conditions = [])
- model_soft_delete(string $model, mixed $id): bool
- db_is_table(string $table): bool
- db_is_column(string $table, string $column): bool
- db_table_size(string $table): int
- db_last_query(): string
- db_to_csv($query, string $path): bool
- db_seed_random(string $table, int $count, array $data = []): int
- db_copy_table(string $from, string $to): bool
- db_truncate_cascade(string $table): bool
- db_transaction_safe(callable $callback)
- db_lock_table(string $table): bool
- db_unlock_table(): bool
- db_column_type(string $table, string $column): string
- db_list_tables(): array
- db_list_columns(string $table): array
- db_list_indexes(string $table): array
- model_bulk_update(string $model, array $updates): int
- model_bulk_insert(string $model, array $data): int
- model_upsert(string $model, array $data, array $uniqueKeys = ['id']): bool
- model_soft_restore(string $model, mixed $id): bool
- model_force_delete(string $model, mixed $id): bool
- model_scope_exists(string $model, string $scope): bool
- model_relationship_exists(string $model, string $relationship): bool
- db_optimize_table(string $table): bool
- db_repair_table(string $table): bool
- db_analyze_table(string $table): bool
- db_check_table(string $table): bool


