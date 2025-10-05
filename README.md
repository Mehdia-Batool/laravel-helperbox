# Laravel HelperBox — Universal Helper Package

A compact, organized reference for the 600+ helpers in this package. Full, per-function documentation (parameters, return values and extended examples) lives in `docs/FUNCTION_REFERENCE.md` — this README focuses on an organized quick reference and practical examples so you and your users can get started quickly.

## Key points

- 600+ helpers across many domains (Arrays, Strings, Math, Blade, DB, Files, Cache, API, Security, Dev tools, Frontend, Data Science, and more).
- Helpers are simple global functions and are wrapped with `function_exists()` checks.
- Works with Laravel 9/10/11 and plain PHP projects.

## Installation

Composer:

```bash
composer require subhashladumor/laravel-helperbox
```

Laravel auto-discovery registers the service provider. To manually register add:

```php
// config/app.php
'providers' => [
    // ...
    Subhashladumor\LaravelHelperbox\HelperServiceProvider::class,
],
```

## How this README is organized

- Quickstart examples for common categories
- Concise category lists of representative functions
- Links to full documentation

For full function signatures, behaviors, and more examples see `docs/FUNCTION_REFERENCE.md`.

---

## Quickstart — Use cases & examples

Below are organized examples grouped by category. Copy/paste into your app or tinker to try them.

Array helpers

```php
$nested = [1, [2, [3, 4]], 5];
$flat = array_flatten_recursive($nested); // [1,2,3,4,5]

$users = [
  ['id'=>1,'role'=>'admin'],
  ['id'=>2,'role'=>'user'],
];
$grouped = array_group_by($users, 'role');
// ['admin' => [['id'=>1,...]], 'user' => [['id'=>2,...]]]

$csv = array_to_csv([['a','b'],['c','d']]);
// "a,b\n c,d\n"
```

String helpers

```php
str_slugify('Hello World!');              // 'hello-world'
str_to_camel_case('hello_world_example'); // 'helloWorldExample'
str_mask_middle('john.doe@example.com', 2); // 'jo****@example.com'
str_levenshtein_distance('kitten','sitting'); // int distance
```

Math & Algorithms

```php
math_factorial(5);        // 120
math_fibonacci(10);       // 55
math_is_prime(17);        // true
$g = math_gcd(48,18);     // 6
```

Date & Time

```php
date_is_today(now());
date_diff_in_days('2024-01-01','2024-01-15'); // 14
date_ago(now()->subHours(3)); // '3 hours ago'
```

Blade & Templating

```blade
{{-- In Blade templates --}}
@ifroute('admin.dashboard')
  <p>Admin Dashboard</p>
@endifroute

@ifrole('admin')
  <p>Only for admins</p>
@endifrole
```

Model & Database

```php
model_exists(App\\Models\\User::class, 1); // true|false
$dbsize = db_table_size('users');
db_export_to_json('posts'); // writes JSON to storage/app
```

File & Streaming

```php
file_get_mime(storage_path('app/photo.jpg')); // 'image/jpeg'
$fileList = file_list_recursive(base_path('tests/fixtures'));
return file_stream_to_response(storage_path('app/big.csv'), 'big.csv');
```

Cache & Session

```php
cache_has_or_store('report:v1', fn()=>build_report(), 3600);
session_flash_success('Saved successfully');
```

HTTP & API

```php
$users = http_get_json('https://api.example.com/users');
return api_success($users, 'Fetched users');

// Retry example
$response = api_request_retry('https://api.svc/endpoint', 'post', ['a'=>1], 3);
```

Validation & Security

```php
validate_email('test@example.com'); // true
validate_credit_card('4111111111111111'); // true (Luhn)
$secret = auth_two_factor_generate($user);
auth_two_factor_verify($user, $code);
```

Developer utilities

```php
// Time a DB query
dev_query_timer(function(){ return DB::table('users')->count(); });
// Dump SQL with bindings
dev_dump_sql(User::where('active',1)->toSql(), User::getBindings());
```

Frontend optimizations

```php
$html = file_get_contents(public_path('index.html'));
$html = frontend_inline_critical_css($html, 'body{...}');
$html = frontend_lazyload_images($html);
```

Data Science & AI helpers

```php
$mean = ds_mean([1,2,3,4]);
$forecast = ds_forecast_next([10,12,13,12,15], 3);
$clusters = ds_cluster_kmeans($points, 3);
```

---

## Organized categories (concise list)

Each category below lists representative helpers. The complete list with signatures and examples is in `docs/FUNCTION_REFERENCE.md`.

- Array: array_flatten_recursive, array_to_xml, array_group_by, array_multi_search, array_pluck_recursive, array_merge_recursive_distinct, array_to_csv, array_random_subset
- String: str_slugify, str_to_camel_case, str_to_snake_case, str_mask_middle, str_levenshtein_distance, str_random_alnum, str_title_case
- Math & Algorithms: math_factorial, math_fibonacci, math_is_prime, math_gcd, math_lcm, math_matrix_multiply, math_fft
- Blade: blade_if_route, blade_if_role, blade_format_date, blade_asset_version, blade_inline_svg
- Model & DB: model_exists, model_clone_with_relations, db_table_exists, db_column_exists, db_upsert_batch, db_stream_query
- File & Path: file_get_extension, file_get_mime, file_copy_recursive, file_delete_recursive, file_stream_to_response, file_temp
- Memory & System: memory_usage, memory_peak, cpu_usage, system_uptime, system_loadavg
- Controller & Repository: controller_action_name, controller_class_name, repository_find_by, repository_update_by
- Date & Time: date_is_today, date_diff_in_days, date_start_of_week, date_end_of_month, date_to_timezone, date_ago
- Cache & Session: cache_has_or_store, cache_forget_if_exists, cache_remember_or_lock, cache_invalidate_model, cache_auto_compress
- API & HTTP: http_get_json, http_post_json, api_success, api_error, api_request_retry, api_graphql_query
- Validation: validate_email, validate_url, validate_ip, validate_json, validate_uuid, validate_credit_card
- JS-style utilities: js_array_map_recursive, js_array_flatten_depth, js_debounce, js_throttle, js_memoize
- Advanced caching & performance: cache_ttl_randomized, cache_precompute, cache_or_queue_refresh, cache_stream_file
- File streaming & uploads: file_chunk_upload, file_chunk_merge, file_resume_upload, file_stream_zip, file_temp_link
- System monitoring: system_health_report, system_log_rotation, system_queue_backlog, system_api_failure_rate
- Security & Auth: auth_token_generate, auth_token_verify, auth_two_factor_generate, auth_bruteforce_protect, auth_impersonate
- Dev utilities: dev_query_timer, dev_request_timer, dev_event_trace, dev_mock_http_response
- 3rd-party APIs & integrations: api_request_retry, api_batch_request, api_graphql_query, api_oauth_refresh, api_webhook_verify
- SQL optimization & data utilities: sql_explain_analyze, sql_auto_index_suggestions, sql_batch_insert, sql_stream_query, sql_detect_n_plus_one
- Data Science & Analytics: ds_mean, ds_median, ds_correlation, ds_regression_line, ds_cluster_kmeans
- Frontend & Web optimization: frontend_minify_css, frontend_minify_js, frontend_inline_critical_css, frontend_lazyload_images, frontend_cache_busting
- Geo & Spatial: geo_haversine_distance, geo_point_to_hash, geo_encode_polyline, geo_decode_polyline

---

## Contributing

Contributions, bug reports and improvements are welcome. Please:

1. Open an issue describing the change.
2. Submit a pull request with tests (where applicable).

Follow PSR‑12 style. Run tests with PHPUnit.

---

## Where to find full docs

All functions, grouped by category with parameter lists, return values and usage examples are documented in `docs/FUNCTION_REFERENCE.md`.

If you want, I can:
- Generate a category index (separate markdown files per category)
- Produce example test cases for a selection of helpers
- Add links from each helper listed here to its entry in `docs/FUNCTION_REFERENCE.md`
