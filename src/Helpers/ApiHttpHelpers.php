<?php

use Illuminate\Support\Facades\Http;

/**
 * API & HTTP Helper Functions
 * 
 * This file contains 30+ advanced HTTP and API utility functions
 * for HTTP clients, API responses, and request handling.
 * 
 * @package Subhashladumor\LaravelHelperbox
 * @author Subhash Ladumor
 */

if (!function_exists('http_get_json')) {
    /**
     * Make GET request and return JSON response
     * 
     * @param string $url Request URL
     * @param array $headers HTTP headers
     * @return array|false JSON response or false on error
     */
    function http_get_json(string $url, array $headers = []): array|false
    {
        try {
            $response = Http::withHeaders($headers)->get($url);
            return $response->json();
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('http_post_json')) {
    /**
     * Make POST request with JSON data
     * 
     * @param string $url Request URL
     * @param array $data Request data
     * @param array $headers HTTP headers
     * @return array|false JSON response or false on error
     */
    function http_post_json(string $url, array $data, array $headers = []): array|false
    {
        try {
            $response = Http::withHeaders($headers)->post($url, $data);
            return $response->json();
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('http_put_json')) {
    /**
     * Make PUT request with JSON data
     * 
     * @param string $url Request URL
     * @param array $data Request data
     * @param array $headers HTTP headers
     * @return array|false JSON response or false on error
     */
    function http_put_json(string $url, array $data, array $headers = []): array|false
    {
        try {
            $response = Http::withHeaders($headers)->put($url, $data);
            return $response->json();
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('http_delete_json')) {
    /**
     * Make DELETE request
     * 
     * @param string $url Request URL
     * @param array $headers HTTP headers
     * @return array|false JSON response or false on error
     */
    function http_delete_json(string $url, array $headers = []): array|false
    {
        try {
            $response = Http::withHeaders($headers)->delete($url);
            return $response->json();
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('http_status_message')) {
    /**
     * Get HTTP status message
     * 
     * @param int $code HTTP status code
     * @return string Status message
     */
    function http_status_message(int $code): string
    {
        $messages = [
            200 => 'OK',
            201 => 'Created',
            204 => 'No Content',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
        ];
        
        return $messages[$code] ?? 'Unknown';
    }
}

if (!function_exists('http_is_success')) {
    /**
     * Check if HTTP status code is success (2xx)
     * 
     * @param int $code HTTP status code
     * @return bool True if success
     */
    function http_is_success(int $code): bool
    {
        return $code >= 200 && $code < 300;
    }
}

if (!function_exists('http_is_redirect')) {
    /**
     * Check if HTTP status code is redirect (3xx)
     * 
     * @param int $code HTTP status code
     * @return bool True if redirect
     */
    function http_is_redirect(int $code): bool
    {
        return $code >= 300 && $code < 400;
    }
}

if (!function_exists('http_is_error')) {
    /**
     * Check if HTTP status code is error (4xx or 5xx)
     * 
     * @param int $code HTTP status code
     * @return bool True if error
     */
    function http_is_error(int $code): bool
    {
        return $code >= 400;
    }
}

if (!function_exists('api_success')) {
    /**
     * Create success API response
     * 
     * @param mixed $data Response data
     * @param string $message Success message
     * @param int $code HTTP status code
     * @return \Illuminate\Http\JsonResponse
     */
    function api_success($data = null, string $message = 'OK', int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}

if (!function_exists('api_error')) {
    /**
     * Create error API response
     * 
     * @param string $message Error message
     * @param int $code HTTP status code
     * @param mixed $errors Additional error details
     * @return \Illuminate\Http\JsonResponse
     */
    function api_error(string $message = 'Error', int $code = 400, $errors = null)
    {
        $response = [
            'success' => false,
            'message' => $message
        ];
        
        if ($errors !== null) {
            $response['errors'] = $errors;
        }
        
        return response()->json($response, $code);
    }
}

if (!function_exists('api_validation_error')) {
    /**
     * Create validation error API response
     * 
     * @param array $errors Validation errors
     * @param string $message Error message
     * @return \Illuminate\Http\JsonResponse
     */
    function api_validation_error(array $errors, string $message = 'Validation failed')
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], 422);
    }
}

if (!function_exists('api_not_found')) {
    /**
     * Create not found API response
     * 
     * @param string $message Error message
     * @return \Illuminate\Http\JsonResponse
     */
    function api_not_found(string $message = 'Not Found')
    {
        return api_error($message, 404);
    }
}

if (!function_exists('api_unauthorized')) {
    /**
     * Create unauthorized API response
     * 
     * @param string $message Error message
     * @return \Illuminate\Http\JsonResponse
     */
    function api_unauthorized(string $message = 'Unauthorized')
    {
        return api_error($message, 401);
    }
}

if (!function_exists('api_forbidden')) {
    /**
     * Create forbidden API response
     * 
     * @param string $message Error message
     * @return \Illuminate\Http\JsonResponse
     */
    function api_forbidden(string $message = 'Forbidden')
    {
        return api_error($message, 403);
    }
}

if (!function_exists('api_internal_error')) {
    /**
     * Create internal server error API response
     * 
     * @param string $message Error message
     * @return \Illuminate\Http\JsonResponse
     */
    function api_internal_error(string $message = 'Internal Server Error')
    {
        return api_error($message, 500);
    }
}

if (!function_exists('api_created')) {
    /**
     * Create created API response
     * 
     * @param mixed $data Response data
     * @param string $message Success message
     * @return \Illuminate\Http\JsonResponse
     */
    function api_created($data = null, string $message = 'Created')
    {
        return api_success($data, $message, 201);
    }
}

if (!function_exists('api_no_content')) {
    /**
     * Create no content API response
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    function api_no_content()
    {
        return response()->json(null, 204);
    }
}

if (!function_exists('api_paginate_response')) {
    /**
     * Create paginated API response
     * 
     * @param mixed $data Paginated data
     * @param int $page Current page
     * @param int $perPage Items per page
     * @return \Illuminate\Http\JsonResponse
     */
    function api_paginate_response($data, int $page, int $perPage)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $data->total(),
                'last_page' => $data->lastPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem()
            ]
        ]);
    }
}

if (!function_exists('http_timeout')) {
    /**
     * Make HTTP request with timeout
     * 
     * @param string $method HTTP method
     * @param string $url Request URL
     * @param array $options Request options
     * @param int $timeout Timeout in seconds
     * @return \Illuminate\Http\Client\Response
     */
    function http_timeout(string $method, string $url, array $options = [], int $timeout = 30)
    {
        return Http::timeout($timeout)->{strtolower($method)}($url, $options);
    }
}

if (!function_exists('http_retry')) {
    /**
     * Make HTTP request with retry logic
     * 
     * @param string $method HTTP method
     * @param string $url Request URL
     * @param array $options Request options
     * @param int $retries Number of retries
     * @return \Illuminate\Http\Client\Response
     */
    function http_retry(string $method, string $url, array $options = [], int $retries = 3)
    {
        return Http::retry($retries)->{strtolower($method)}($url, $options);
    }
}

if (!function_exists('http_with_auth')) {
    /**
     * Make HTTP request with authentication
     * 
     * @param string $method HTTP method
     * @param string $url Request URL
     * @param string $token Auth token
     * @param array $options Request options
     * @return \Illuminate\Http\Client\Response
     */
    function http_with_auth(string $method, string $url, string $token, array $options = [])
    {
        return Http::withToken($token)->{strtolower($method)}($url, $options);
    }
}

if (!function_exists('http_download')) {
    /**
     * Download file from URL
     * 
     * @param string $url File URL
     * @param string $path Local path to save
     * @return bool True if successful
     */
    function http_download(string $url, string $path): bool
    {
        try {
            $response = Http::get($url);
            return file_put_contents($path, $response->body()) !== false;
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('http_upload')) {
    /**
     * Upload file via HTTP
     * 
     * @param string $url Upload URL
     * @param string $filePath File path
     * @param array $headers HTTP headers
     * @return array|false Response or false on error
     */
    function http_upload(string $url, string $filePath, array $headers = []): array|false
    {
        try {
            $response = Http::withHeaders($headers)->attach('file', file_get_contents($filePath), basename($filePath))->post($url);
            return $response->json();
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('http_validate_url')) {
    /**
     * Validate URL format
     * 
     * @param string $url URL to validate
     * @return bool True if valid
     */
    function http_validate_url(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
}

if (!function_exists('http_get_domain')) {
    /**
     * Extract domain from URL
     * 
     * @param string $url URL
     * @return string|false Domain or false on error
     */
    function http_get_domain(string $url): string|false
    {
        $parsed = parse_url($url);
        return $parsed['host'] ?? false;
    }
}

if (!function_exists('http_get_path')) {
    /**
     * Extract path from URL
     * 
     * @param string $url URL
     * @return string|false Path or false on error
     */
    function http_get_path(string $url): string|false
    {
        $parsed = parse_url($url);
        return $parsed['path'] ?? false;
    }
}

if (!function_exists('http_get_query')) {
    /**
     * Extract query parameters from URL
     * 
     * @param string $url URL
     * @return array Query parameters
     */
    function http_get_query(string $url): array
    {
        $parsed = parse_url($url);
        parse_str($parsed['query'] ?? '', $query);
        return $query;
    }
}

if (!function_exists('http_build_query_url')) {
    /**
     * Build URL with query parameters
     * 
     * @param string $url Base URL
     * @param array $params Query parameters
     * @return string URL with query string
     */
    function http_build_query_url(string $url, array $params): string
    {
        $query = http_build_query($params);
        return $url . (strpos($url, '?') !== false ? '&' : '?') . $query;
    }
}

if (!function_exists('api_rate_limit_exceeded')) {
    /**
     * Create rate limit exceeded API response
     * 
     * @param string $message Error message
     * @return \Illuminate\Http\JsonResponse
     */
    function api_rate_limit_exceeded(string $message = 'Rate limit exceeded')
    {
        return api_error($message, 429);
    }
}

if (!function_exists('api_download_response')) {
    /**
     * Create file download API response
     * 
     * @param string $filePath File path
     * @param string|null $fileName Download filename
     * @return \Illuminate\Http\Response
     */
    function api_download_response(string $filePath, ?string $fileName = null)
    {
        $fileName = $fileName ?? basename($filePath);
        return response()->download($filePath, $fileName);
    }
}
