<?php

/**
 * File & Path Helper Functions
 * 
 * This file contains 30+ advanced file and path utility functions
 * for file operations, metadata extraction, and path manipulation.
 * 
 * @package Subhashladumor\LaravelHelperbox
 * @author Subhash Ladumor
 */

if (!function_exists('file_get_extension')) {
    /**
     * Get file extension safely
     * 
     * @param string $path File path
     * @return string File extension
     */
    function file_get_extension(string $path): string
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        return strtolower($extension);
    }
}

if (!function_exists('file_get_mime')) {
    /**
     * Detect MIME type of file
     * 
     * @param string $path File path
     * @return string MIME type
     */
    function file_get_mime(string $path): string
    {
        if (!file_exists($path)) {
            return '';
        }
        
        $mimeType = mime_content_type($path);
        
        if ($mimeType === false) {
            $extension = file_get_extension($path);
            $mimeTypes = [
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'pdf' => 'application/pdf',
                'txt' => 'text/plain',
                'html' => 'text/html',
                'css' => 'text/css',
                'js' => 'application/javascript',
                'json' => 'application/json',
                'xml' => 'application/xml',
            ];
            
            return $mimeTypes[$extension] ?? 'application/octet-stream';
        }
        
        return $mimeType;
    }
}

if (!function_exists('file_size_human')) {
    /**
     * Get human-readable file size
     * 
     * @param string $path File path
     * @return string Human-readable size
     */
    function file_size_human(string $path): string
    {
        if (!file_exists($path)) {
            return '0 B';
        }
        
        $bytes = filesize($path);
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}

if (!function_exists('file_is_image')) {
    /**
     * Check if file is an image
     * 
     * @param string $path File path
     * @return bool True if image
     */
    function file_is_image(string $path): bool
    {
        if (!file_exists($path)) {
            return false;
        }
        
        $mimeType = file_get_mime($path);
        return strpos($mimeType, 'image/') === 0;
    }
}

if (!function_exists('file_is_video')) {
    /**
     * Check if file is video
     * 
     * @param string $path File path
     * @return bool True if video
     */
    function file_is_video(string $path): bool
    {
        if (!file_exists($path)) {
            return false;
        }
        
        $mimeType = file_get_mime($path);
        return strpos($mimeType, 'video/') === 0;
    }
}

if (!function_exists('file_random_name')) {
    /**
     * Generate random filename with extension
     * 
     * @param string $extension File extension
     * @param int $length Random part length
     * @return string Random filename
     */
    function file_random_name(string $extension = 'txt', int $length = 10): string
    {
        $random = str_random_alnum($length);
        return $random . '.' . ltrim($extension, '.');
    }
}

if (!function_exists('file_copy_recursive')) {
    /**
     * Copy directory recursively
     * 
     * @param string $from Source directory
     * @param string $to Destination directory
     * @return bool True if successful
     */
    function file_copy_recursive(string $from, string $to): bool
    {
        if (!is_dir($from)) {
            return false;
        }
        
        if (!is_dir($to)) {
            if (!mkdir($to, 0755, true)) {
                return false;
            }
        }
        
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($from, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        
        foreach ($iterator as $item) {
            $target = $to . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
            
            if ($item->isDir()) {
                if (!is_dir($target) && !mkdir($target, 0755, true)) {
                    return false;
                }
            } else {
                if (!copy($item, $target)) {
                    return false;
                }
            }
        }
        
        return true;
    }
}

if (!function_exists('file_delete_recursive')) {
    /**
     * Delete directory recursively
     * 
     * @param string $path Directory path
     * @return bool True if successful
     */
    function file_delete_recursive(string $path): bool
    {
        if (!is_dir($path)) {
            return false;
        }
        
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        
        foreach ($iterator as $item) {
            if ($item->isDir()) {
                rmdir($item->getRealPath());
            } else {
                unlink($item->getRealPath());
            }
        }
        
        return rmdir($path);
    }
}

if (!function_exists('file_list_recursive')) {
    /**
     * List all files recursively
     * 
     * @param string $path Directory path
     * @param string $pattern File pattern (optional)
     * @return array Array of file paths
     */
    function file_list_recursive(string $path, string $pattern = '*'): array
    {
        if (!is_dir($path)) {
            return [];
        }
        
        $files = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                if ($pattern === '*' || fnmatch($pattern, $file->getFilename())) {
                    $files[] = $file->getPathname();
                }
            }
        }
        
        return $files;
    }
}

if (!function_exists('file_is_writable')) {
    /**
     * Check if file/directory is writable
     * 
     * @param string $path File or directory path
     * @return bool True if writable
     */
    function file_is_writable(string $path): bool
    {
        if (!file_exists($path)) {
            return false;
        }
        
        return is_writable($path);
    }
}

if (!function_exists('file_is_readable')) {
    /**
     * Check if file/directory is readable
     * 
     * @param string $path File or directory path
     * @return bool True if readable
     */
    function file_is_readable(string $path): bool
    {
        if (!file_exists($path)) {
            return false;
        }
        
        return is_readable($path);
    }
}

if (!function_exists('file_temp')) {
    /**
     * Create temporary file with content
     * 
     * @param string $content File content
     * @param string $extension File extension
     * @return string Temporary file path
     */
    function file_temp(string $content, string $extension = 'txt'): string
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'temp_') . '.' . $extension;
        file_put_contents($tempFile, $content);
        return $tempFile;
    }
}

if (!function_exists('file_lock')) {
    /**
     * Lock a file for writing
     * 
     * @param string $path File path
     * @param int $operation Lock operation
     * @return resource|false File handle or false
     */
    function file_lock(string $path, int $operation = LOCK_EX)
    {
        $handle = fopen($path, 'c+');
        
        if ($handle === false) {
            return false;
        }
        
        if (flock($handle, $operation)) {
            return $handle;
        }
        
        fclose($handle);
        return false;
    }
}

if (!function_exists('file_unlock')) {
    /**
     * Unlock a file
     * 
     * @param resource $handle File handle
     * @return bool True if successful
     */
    function file_unlock($handle): bool
    {
        if (!is_resource($handle)) {
            return false;
        }
        
        $result = flock($handle, LOCK_UN);
        fclose($handle);
        
        return $result;
    }
}

if (!function_exists('file_is_symlink')) {
    /**
     * Check if path is symbolic link
     * 
     * @param string $path Path to check
     * @return bool True if symbolic link
     */
    function file_is_symlink(string $path): bool
    {
        return is_link($path);
    }
}

if (!function_exists('file_hash')) {
    /**
     * Calculate file hash
     * 
     * @param string $path File path
     * @param string $algorithm Hash algorithm
     * @return string File hash
     */
    function file_hash(string $path, string $algorithm = 'md5'): string
    {
        if (!file_exists($path)) {
            return '';
        }
        
        return hash_file($algorithm, $path);
    }
}

if (!function_exists('file_compare')) {
    /**
     * Compare two files
     * 
     * @param string $path1 First file path
     * @param string $path2 Second file path
     * @return bool True if files are identical
     */
    function file_compare(string $path1, string $path2): bool
    {
        if (!file_exists($path1) || !file_exists($path2)) {
            return false;
        }
        
        return file_hash($path1) === file_hash($path2);
    }
}

if (!function_exists('file_search')) {
    /**
     * Search text inside file
     * 
     * @param string $path File path
     * @param string $search Search term
     * @param bool $caseSensitive Case sensitive search
     * @return array Array of matching lines
     */
    function file_search(string $path, string $search, bool $caseSensitive = false): array
    {
        if (!file_exists($path) || !is_readable($path)) {
            return [];
        }
        
        $content = file_get_contents($path);
        $lines = explode("\n", $content);
        $matches = [];
        
        foreach ($lines as $lineNumber => $line) {
            $searchLine = $caseSensitive ? $line : strtolower($line);
            $searchTerm = $caseSensitive ? $search : strtolower($search);
            
            if (strpos($searchLine, $searchTerm) !== false) {
                $matches[] = [
                    'line' => $lineNumber + 1,
                    'content' => $line
                ];
            }
        }
        
        return $matches;
    }
}

if (!function_exists('file_replace')) {
    /**
     * Replace text in file
     * 
     * @param string $path File path
     * @param string $search Search term
     * @param string $replace Replacement text
     * @param bool $caseSensitive Case sensitive replacement
     * @return bool True if successful
     */
    function file_replace(string $path, string $search, string $replace, bool $caseSensitive = false): bool
    {
        if (!file_exists($path) || !is_writable($path)) {
            return false;
        }
        
        $content = file_get_contents($path);
        
        if ($caseSensitive) {
            $newContent = str_replace($search, $replace, $content);
        } else {
            $newContent = str_ireplace($search, $replace, $content);
        }
        
        return file_put_contents($path, $newContent) !== false;
    }
}

if (!function_exists('file_tail')) {
    /**
     * Get last N lines of file
     * 
     * @param string $path File path
     * @param int $lines Number of lines to get
     * @return array Array of lines
     */
    function file_tail(string $path, int $lines = 10): array
    {
        if (!file_exists($path) || !is_readable($path)) {
            return [];
        }
        
        $file = new SplFileObject($path);
        $file->seek(PHP_INT_MAX);
        $totalLines = $file->key() + 1;
        
        $startLine = max(0, $totalLines - $lines);
        $file->seek($startLine);
        
        $result = [];
        while (!$file->eof()) {
            $result[] = $file->current();
            $file->next();
        }
        
        return $result;
    }
}

if (!function_exists('file_head')) {
    /**
     * Get first N lines of file
     * 
     * @param string $path File path
     * @param int $lines Number of lines to get
     * @return array Array of lines
     */
    function file_head(string $path, int $lines = 10): array
    {
        if (!file_exists($path) || !is_readable($path)) {
            return [];
        }
        
        $file = new SplFileObject($path);
        $result = [];
        
        for ($i = 0; $i < $lines && !$file->eof(); $i++) {
            $result[] = $file->current();
            $file->next();
        }
        
        return $result;
    }
}

if (!function_exists('file_line_count')) {
    /**
     * Count lines in file
     * 
     * @param string $path File path
     * @return int Number of lines
     */
    function file_line_count(string $path): int
    {
        if (!file_exists($path) || !is_readable($path)) {
            return 0;
        }
        
        $file = new SplFileObject($path);
        $file->seek(PHP_INT_MAX);
        return $file->key() + 1;
    }
}

if (!function_exists('file_word_count')) {
    /**
     * Count words in file
     * 
     * @param string $path File path
     * @return int Number of words
     */
    function file_word_count(string $path): int
    {
        if (!file_exists($path) || !is_readable($path)) {
            return 0;
        }
        
        $content = file_get_contents($path);
        return str_word_count($content);
    }
}

if (!function_exists('file_character_count')) {
    /**
     * Count characters in file
     * 
     * @param string $path File path
     * @param bool $withSpaces Include spaces in count
     * @return int Number of characters
     */
    function file_character_count(string $path, bool $withSpaces = true): int
    {
        if (!file_exists($path) || !is_readable($path)) {
            return 0;
        }
        
        $content = file_get_contents($path);
        
        if (!$withSpaces) {
            $content = str_replace(' ', '', $content);
        }
        
        return strlen($content);
    }
}

if (!function_exists('file_ensure_directory')) {
    /**
     * Ensure directory exists, create if not
     * 
     * @param string $path Directory path
     * @param int $permissions Directory permissions
     * @return bool True if directory exists or was created
     */
    function file_ensure_directory(string $path, int $permissions = 0755): bool
    {
        if (is_dir($path)) {
            return true;
        }
        
        return mkdir($path, $permissions, true);
    }
}

if (!function_exists('file_clean_name')) {
    /**
     * Clean filename by removing invalid characters
     * 
     * @param string $filename Filename to clean
     * @return string Cleaned filename
     */
    function file_clean_name(string $filename): string
    {
        // Remove invalid characters
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
        
        // Remove multiple underscores
        $filename = preg_replace('/_+/', '_', $filename);
        
        // Remove leading/trailing underscores and dots
        $filename = trim($filename, '._');
        
        return $filename;
    }
}

if (!function_exists('file_get_directory_size')) {
    /**
     * Get total size of directory
     * 
     * @param string $path Directory path
     * @return int Total size in bytes
     */
    function file_get_directory_size(string $path): int
    {
        if (!is_dir($path)) {
            return 0;
        }
        
        $size = 0;
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $size += $file->getSize();
            }
        }
        
        return $size;
    }
}

if (!function_exists('file_get_directory_size_human')) {
    /**
     * Get human-readable directory size
     * 
     * @param string $path Directory path
     * @return string Human-readable size
     */
    function file_get_directory_size_human(string $path): string
    {
        $bytes = file_get_directory_size($path);
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}

if (!function_exists('file_backup')) {
    /**
     * Create backup of file
     * 
     * @param string $path File path
     * @param string $backupDir Backup directory
     * @return string|false Backup file path or false
     */
    function file_backup(string $path, string $backupDir = null)
    {
        if (!file_exists($path)) {
            return false;
        }
        
        if ($backupDir === null) {
            $backupDir = dirname($path) . '/backups';
        }
        
        if (!file_ensure_directory($backupDir)) {
            return false;
        }
        
        $filename = basename($path);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $name = pathinfo($filename, PATHINFO_FILENAME);
        $timestamp = date('Y-m-d_H-i-s');
        
        $backupPath = $backupDir . '/' . $name . '_' . $timestamp . '.' . $extension;
        
        if (copy($path, $backupPath)) {
            return $backupPath;
        }
        
        return false;
    }
}
