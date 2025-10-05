### FilePathHelpers

Filesystem and path utilities: metadata, recursive ops, locks, search/replace, tail/head, hashing, backups.

#### Function Index

- file_get_extension(string $path): string
- file_get_mime(string $path): string
- file_size_human(string $path): string
- file_is_image(string $path): bool
- file_is_video(string $path): bool
- file_random_name(string $extension = 'txt', int $length = 10): string
- file_copy_recursive(string $from, string $to): bool
- file_delete_recursive(string $path): bool
- file_list_recursive(string $path, string $pattern = '*'): array
- file_is_writable(string $path): bool
- file_is_readable(string $path): bool
- file_temp(string $content, string $extension = 'txt'): string
- file_lock(string $path, int $operation = LOCK_EX)
- file_unlock($handle): bool
- file_is_symlink(string $path): bool
- file_hash(string $path, string $algorithm = 'md5'): string
- file_compare(string $path1, string $path2): bool
- file_search(string $path, string $search, bool $caseSensitive = false): array
- file_replace(string $path, string $search, string $replace, bool $caseSensitive = false): bool
- file_tail(string $path, int $lines = 10): array
- file_head(string $path, int $lines = 10): array
- file_line_count(string $path): int
- file_word_count(string $path): int
- file_character_count(string $path, bool $withSpaces = true): int
- file_ensure_directory(string $path, int $permissions = 0755): bool
- file_clean_name(string $filename): string
- file_get_directory_size(string $path): int
- file_get_directory_size_human(string $path): string
- file_backup(string $path, string $backupDir = null)


