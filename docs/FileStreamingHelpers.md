### FileStreamingHelpers

Chunked uploads/merges, streaming downloads, temp URLs, simple file crypto, and image metadata.

#### Function Index

- stream_file_response(string $path, string $downloadAs = null, array $headers = []): StreamedResponse
- upload_chunk_save(string $tmpDir, string $uploadId, int $index, string $contents): bool
- upload_chunk_merge(string $tmpDir, string $uploadId, int $totalChunks, string $targetPath): bool
- file_temp_link(string $disk, string $path, int $seconds = 300): string
- file_sha256(string $path): string|false
- file_compare(string $a, string $b): bool
- file_simple_encrypt(string $inputPath, string $outputPath, string $password): bool
- file_simple_decrypt(string $inputPath, string $outputPath, string $password): bool
- image_get_dimensions(string $path): array|false
- text_stream_download(string $filename, iterable $lines, array $headers = []): StreamedResponse


