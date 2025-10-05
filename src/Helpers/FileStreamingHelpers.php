<?php

/**
 * File & Streaming Helper Functions
 *
 * Chunked uploads/merges, streaming responses, temporary links, hashing,
 * simple encryption helpers, and basic media metadata utilities.
 *
 * @package Subhashladumor\LaravelHelperbox
 */

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

if (!function_exists('stream_file_response')) {
    function stream_file_response(string $path, string $downloadAs = null, array $headers = []): StreamedResponse
    {
        $downloadAs = $downloadAs ?? basename($path);
        return response()->streamDownload(function () use ($path) {
            $stream = fopen($path, 'rb');
            if ($stream) {
                while (!feof($stream)) {
                    echo fread($stream, 8192);
                    flush();
                }
                fclose($stream);
            }
        }, $downloadAs, $headers);
    }
}

if (!function_exists('upload_chunk_save')) {
    function upload_chunk_save(string $tmpDir, string $uploadId, int $index, string $contents): bool
    {
        if (!is_dir($tmpDir)) mkdir($tmpDir, 0777, true);
        $chunkPath = rtrim($tmpDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $uploadId . ".part{$index}";
        return file_put_contents($chunkPath, $contents) !== false;
    }
}

if (!function_exists('upload_chunk_merge')) {
    function upload_chunk_merge(string $tmpDir, string $uploadId, int $totalChunks, string $targetPath): bool
    {
        $out = fopen($targetPath, 'wb');
        if (!$out) return false;
        for ($i = 0; $i < $totalChunks; $i++) {
            $chunkPath = rtrim($tmpDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $uploadId . ".part{$i}";
            if (!file_exists($chunkPath)) { fclose($out); return false; }
            $in = fopen($chunkPath, 'rb');
            stream_copy_to_stream($in, $out);
            fclose($in);
        }
        fclose($out);
        return true;
    }
}

if (!function_exists('file_temp_link')) {
    function file_temp_link(string $disk, string $path, int $seconds = 300): string
    {
        return Storage::disk($disk)->temporaryUrl($path, now()->addSeconds($seconds));
    }
}

if (!function_exists('file_sha256')) {
    function file_sha256(string $path): string|false
    {
        return file_exists($path) ? hash_file('sha256', $path) : false;
    }
}

if (!function_exists('file_compare')) {
    function file_compare(string $a, string $b): bool
    {
        if (!file_exists($a) || !file_exists($b)) return false;
        if (filesize($a) !== filesize($b)) return false;
        $fa = fopen($a, 'rb'); $fb = fopen($b, 'rb');
        $same = true;
        while (!feof($fa) && !feof($fb)) {
            if (fread($fa, 8192) !== fread($fb, 8192)) { $same = false; break; }
        }
        fclose($fa); fclose($fb);
        return $same;
    }
}

if (!function_exists('file_simple_encrypt')) {
    function file_simple_encrypt(string $inputPath, string $outputPath, string $password): bool
    {
        if (!file_exists($inputPath)) return false;
        $data = file_get_contents($inputPath);
        $iv = random_bytes(16);
        $cipher = openssl_encrypt($data, 'AES-256-CBC', hash('sha256', $password, true), OPENSSL_RAW_DATA, $iv);
        return file_put_contents($outputPath, $iv . $cipher) !== false;
    }
}

if (!function_exists('file_simple_decrypt')) {
    function file_simple_decrypt(string $inputPath, string $outputPath, string $password): bool
    {
        if (!file_exists($inputPath)) return false;
        $raw = file_get_contents($inputPath);
        $iv = substr($raw, 0, 16);
        $ciphertext = substr($raw, 16);
        $plain = openssl_decrypt($ciphertext, 'AES-256-CBC', hash('sha256', $password, true), OPENSSL_RAW_DATA, $iv);
        return file_put_contents($outputPath, $plain) !== false;
    }
}

if (!function_exists('image_get_dimensions')) {
    function image_get_dimensions(string $path): array|false
    {
        if (!file_exists($path)) return false;
        $info = getimagesize($path);
        return $info ? ['width' => $info[0], 'height' => $info[1], 'mime' => $info['mime'] ?? null] : false;
    }
}

if (!function_exists('text_stream_download')) {
    function text_stream_download(string $filename, iterable $lines, array $headers = []): StreamedResponse
    {
        return response()->streamDownload(function () use ($lines) {
            foreach ($lines as $line) { echo rtrim((string) $line, "\r\n") . "\n"; flush(); }
        }, $filename, $headers);
    }
}

?>


