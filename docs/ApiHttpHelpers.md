### ApiHttpHelpers

Convenience wrappers around Laravel HTTP client and JSON API responses.

#### Function Index

- http_get_json(string $url, array $headers = []): array|false
- http_post_json(string $url, array $data, array $headers = []): array|false
- http_put_json(string $url, array $data, array $headers = []): array|false
- http_delete_json(string $url, array $headers = []): array|false
- http_status_message(int $code): string
- http_is_success(int $code): bool
- http_is_redirect(int $code): bool
- http_is_error(int $code): bool
- api_success(mixed $data = null, string $message = 'OK', int $code = 200)
- api_error(string $message = 'Error', int $code = 400, mixed $errors = null)
- api_validation_error(array $errors, string $message = 'Validation failed')
- api_not_found(string $message = 'Not Found')
- api_unauthorized(string $message = 'Unauthorized')
- api_forbidden(string $message = 'Forbidden')
- api_internal_error(string $message = 'Internal Server Error')
- api_created(mixed $data = null, string $message = 'Created')
- api_no_content()
- api_paginate_response($data, int $page, int $perPage)
- http_timeout(string $method, string $url, array $options = [], int $timeout = 30)
- http_retry(string $method, string $url, array $options = [], int $retries = 3)
- http_with_auth(string $method, string $url, string $token, array $options = [])
- http_download(string $url, string $path): bool
- http_upload(string $url, string $filePath, array $headers = []): array|false
- http_validate_url(string $url): bool
- http_get_domain(string $url): string|false
- http_get_path(string $url): string|false
- http_get_query(string $url): array
- http_build_query_url(string $url, array $params): string
- api_rate_limit_exceeded(string $message = 'Rate limit exceeded')
- api_download_response(string $filePath, ?string $fileName = null)

#### Examples

```php
$data = http_get_json('https://api.github.com');
return api_success($data);
```


