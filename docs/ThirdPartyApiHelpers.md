### ThirdPartyApiHelpers

Helpers for robust integrations: retries, GraphQL, signatures, webhooks, and response masking.

#### Function Index

- api_retry_backoff(callable $fn, int $tries = 3, int $baseMs = 200)
- api_graphql_query(string $endpoint, string $query, array $variables = [], array $headers = []): array|false
- api_sign_request(string $method, string $path, array $params, string $secret): string
- api_verify_webhook(string $payload, string $signature, string $secret): bool
- api_mask_sensitive(array $data, array $fields = ['token','password','secret']): array

#### Examples

```php
$result = api_retry_backoff(fn() => http_get_json($url));
$sig = api_sign_request('POST', '/v1/pay', ['amount' => 10], $secret);
```


