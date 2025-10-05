<?php

/**
 * 3rd-Party API & Integration Helpers
 *
 * Retry/backoff, batch requests simulation, GraphQL query helper, OAuth token
 * refresh callback integration, signature auth helper, webhook verify/dispatch,
 * and response sanitization.
 *
 * @package Subhashladumor\LaravelHelperbox
 */

if (!function_exists('api_retry_backoff')) {
    function api_retry_backoff(callable $fn, int $tries = 3, int $baseMs = 200)
    {
        $attempt = 0; $last = null;
        while ($attempt < $tries) {
            try { return $fn($attempt); } catch (\Throwable $e) {
                $last = $e; $attempt++;
                usleep(($baseMs * (2 ** ($attempt - 1))) * 1000);
            }
        }
        if ($last) throw $last;
        return null;
    }
}

if (!function_exists('api_graphql_query')) {
    function api_graphql_query(string $endpoint, string $query, array $variables = [], array $headers = []): array|false
    {
        try {
            $payload = ['query' => $query, 'variables' => $variables];
            $response = \Http::withHeaders(array_merge(['Content-Type' => 'application/json'], $headers))
                ->post($endpoint, $payload);
            return $response->json();
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('api_sign_request')) {
    function api_sign_request(string $method, string $path, array $params, string $secret): string
    {
        ksort($params);
        $base = strtoupper($method) . '|' . $path . '|' . http_build_query($params);
        return hash_hmac('sha256', $base, $secret);
    }
}

if (!function_exists('api_verify_webhook')) {
    function api_verify_webhook(string $payload, string $signature, string $secret): bool
    {
        $calc = hash_hmac('sha256', $payload, $secret);
        return hash_equals($calc, $signature);
    }
}

if (!function_exists('api_mask_sensitive')) {
    function api_mask_sensitive(array $data, array $fields = ['token','password','secret']): array
    {
        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $v = (string) $data[$field];
                $data[$field] = strlen($v) <= 4 ? '****' : substr($v, 0, 2) . str_repeat('*', max(0, strlen($v) - 4)) . substr($v, -2);
            }
        }
        return $data;
    }
}

?>


