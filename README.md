# Laravel HelperBox — Universal Helper Package

🚀 Laravel HelperBox is a production‑ready toolbox of 600+ global helpers for Laravel and plain PHP. Every helper is a simple function (no static classes), safely wrapped with `function_exists()` checks and optimized for day‑to‑day development.

## ✨ Highlights

- **600+ helpers** across 25+ domains (arrays, strings, math, geo, caching, security, SQL, data science, and more)
- **Simple usage**: call functions directly, e.g. `array_flatten_recursive()`
- **Safe**: every function is guarded via `if (!function_exists())`
- **Laravel-native**: auto‑discovered service provider, Blade directives, Cache/DB/Http facades
- **Well-documented**: full reference with examples in `docs/FUNCTION_REFERENCE.md`
- **Performant**: efficient algorithms, memory‑aware operations, optional caching

## 📦 Installation

### Composer

```bash
composer require subhashladumor/laravel-helperbox
```

### Laravel auto‑discovery

The package will be automatically discovered by Laravel. If you need to manually register it:

```php
// config/app.php
'providers' => [
    // ...
    Subhashladumor\LaravelHelperbox\HelperServiceProvider::class,
],
```

No configuration required.

## 🎯 Quick start

After installation, all helper functions are available globally:

```php
// Array Helpers
$flattened = array_flatten_recursive($multiDimensionalArray);
$xml = array_to_xml($array);
$grouped = array_group_by($array, 'category');

// String Helpers
$slug = str_slugify('Hello World!');
$camel = str_to_camel_case('hello_world');
$masked = str_mask_middle('1234567890', 3);

// Math Helpers
$factorial = math_factorial(5);
$fibonacci = math_fibonacci(10);
$isPrime = math_is_prime(17);

// Date Helpers
$isToday = date_is_today($date);
$daysDiff = date_diff_in_days($date1, $date2);
$humanReadable = date_ago($date);

// Blade Helpers
@ifroute('admin.dashboard')
    <p>Admin Dashboard Content</p>
@endifroute

@ifrole('admin')
    <p>Admin Only Content</p>
@endifrole

// Geo Helpers
$m = geo_haversine_distance(23.0205, 72.5797, 28.6139, 77.2090); // meters
$hash = geo_point_to_hash(23.0205, 72.5797, 7);
$polyline = geo_encode_polyline([[23.02,72.57],[23.03,72.58]]);
```

## 📚 Categories & examples

This README shows representative examples for each category. For a complete, per‑function guide (parameters, returns, examples, and expected results), see:

- docs/FUNCTION_REFERENCE.md — Core helpers (arrays, strings, math, blade, db, files, memory, controllers, date/time, cache/session, http/api, validation, advanced algorithms, advanced strings, advanced math)
- The helper files in `src/Helpers/` — Advanced modules (JS‑style, advanced cache, file streaming, system monitoring, security/auth, dev utilities, 3rd‑party API, SQL optimization, data science/analytics, frontend optimization, geo)

### 🔹 Array Helpers (30+ functions)
- `array_flatten_recursive()` - Flatten multi-dimensional arrays
- `array_to_xml()` - Convert arrays to XML
- `array_group_by()` - Group arrays by key or callback
- `array_multi_search()` - Recursive array search
- `array_partition()` - Partition arrays based on conditions
- `array_merge_recursive_distinct()` - Merge without overwriting
- `array_to_csv()` - Convert arrays to CSV
- And many more...

Example:
```php
$nested = [1,[2,[3,4]],5];
$flat = array_flatten_recursive($nested);        // [1,2,3,4,5]
$grouped = array_group_by([
  ['id'=>1,'role'=>'admin'],
  ['id'=>2,'role'=>'user'],
], 'role'); // ['admin'=>[...], 'user'=>[...]]
```

### 🔹 String Helpers (30+ functions)
- `str_slugify()` - Generate URL slugs
- `str_to_camel_case()` - Convert to camelCase
- `str_mask_middle()` - Mask sensitive strings
- `str_levenshtein_distance()` - Calculate string similarity
- `str_extract_emails()` - Extract email addresses
- `str_highlight()` - Highlight search terms
- And many more...

Example:
```php
str_slugify('Hello World!');                // 'hello-world'
str_to_camel_case('hello_world_example');   // 'helloWorldExample'
str_mask_middle('john.doe@example.com', 2); // 'jo****@example.com'
```

### 🔹 Math Helpers (30+ functions)
- `math_factorial()` - Calculate factorials
- `math_fibonacci()` - Generate Fibonacci numbers
- `math_is_prime()` - Check prime numbers
- `math_gcd()` - Greatest common divisor
- `math_standard_deviation()` - Statistical calculations
- `math_quadratic_roots()` - Solve quadratic equations
- And many more...

Example:
```php
math_factorial(5);        // 120
math_fibonacci(10);       // 55
math_is_prime(17);        // true
math_gcd(48,18);          // 6
```

### 🔹 Blade Helpers (20+ functions)
- `blade_if_route()` - Route-based conditionals
- `blade_if_role()` - Role-based conditionals
- `blade_format_date()` - Date formatting
- `blade_asset_version()` - Asset versioning
- `blade_inline_svg()` - Inline SVG rendering
- And many more...

Example:
```blade
@ifroute('admin.dashboard')
  <p>Admin Dashboard</p>
@endifroute
```

### 🔹 Model & Database Helpers (30+ functions)
- `model_exists()` - Check model existence
- `model_bulk_update()` - Bulk update operations
- `db_table_size()` - Get table sizes
- `db_optimize_table()` - Optimize database tables
- `db_copy_table()` - Copy table structure and data
- And many more...

Example:
```php
model_exists(User::class, 1); // true/false
db_optimize_table('users');   // true
```

### 🔹 File & Path Helpers (30+ functions)
- `file_get_mime()` - Detect MIME types
- `file_copy_recursive()` - Recursive directory copying
- `file_hash()` - Calculate file hashes
- `file_search()` - Search text in files
- `file_backup()` - Create file backups
- And many more...

Example:
```php
file_get_mime('/path/img.jpg');   // 'image/jpeg'
file_copy_recursive('a','b');     // true
```

### 🔹 Memory & System Helpers (20+ functions)
- `memory_usage()` - Get memory usage
- `memory_peak()` - Get peak memory usage
- `system_uptime()` - Get system uptime
- `system_loadavg()` - Get load averages
- `system_health_check()` - Perform health checks
- And many more...

Example:
```php
memory_usage_human(); // '12.3 MB'
system_health_check();
```

### 🔹 Controller & Repository Helpers (20+ functions)
- `controller_action_name()` - Get current action
- `controller_middleware_list()` - List applied middleware
- `repository_find_by()` - Find by field and value
- `repository_bulk_update()` - Bulk update operations
- And many more...

Example:
```php
controller_action_name(); // 'UserController@index'
```

### 🔹 Date & Time Helpers (30+ functions)
- `date_is_today()` - Check if date is today
- `date_diff_in_days()` - Calculate day differences
- `date_start_of_week()` - Get week start
- `date_get_working_days()` - Calculate working days
- `date_format_relative()` - Relative time formatting
- And many more...

Example:
```php
date_diff_in_days('2024-01-01','2024-01-15'); // 14
date_ago(now()->subHours(3));                // '3 hours ago'
```

### 🔹 Cache & Session Helpers (20+ functions)
- `cache_has_or_store()` - Store if not exists
- `cache_increment()` - Increment cache values
- `session_flash_success()` - Flash success messages
- `cache_remember_with_tags()` - Tagged caching
- And many more...

Example:
```php
cache_has_or_store('key', fn()=>expensive(), 3600);
session_flash_success('Saved!');
```

### 🔹 API & HTTP Helpers (30+ functions)
- `http_get_json()` - GET requests with JSON
- `http_post_json()` - POST requests with JSON
- `api_success()` - Success API responses
- `api_error()` - Error API responses
- `http_download()` - File downloads
- And many more...

Example:
```php
use Illuminate\Support\Facades\Http;

$users = http_get_json('https://api.example.com/users');
return api_success($users);
```

### 🔹 Validation Helpers (20+ functions)
- `validate_email()` - Email validation
- `validate_credit_card()` - Credit card validation
- `validate_password_strength()` - Password strength
- `sanitize_string()` - String sanitization
- `validate_all()` - Bulk validation
- And many more...

Example:
```php
validate_email('test@example.com');     // true
validate_credit_card('4111111111111111'); // true
```
### 🔹 JavaScript‑style Helpers (40+ functions)
- Lodash‑like utilities: `flatten_deep`, `group_by`, `unique_by`, `zip_arrays`, `order_by`, `key_by`, `intersection`, `difference`, `union_arrays`
- Function helpers: `once`, `memoize`, `debounce`, `throttle`, `pipe`, `compose`, `curry`, `partial`

Example:
```php
$unique = unique_by([["id"=>1],["id"=>1],["id"=>2]], 'id'); // [[id=>1],[id=>2]]
```

### 🔹 Advanced Cache Helpers (40+ functions)
- Stampede prevention, tagged/versioned keys, jittered TTLs, chunked/cache‑compressed payloads, locks, rate limiting

Example:
```php
$out = cache_with_jitter('report:v1', 3600, 15, fn()=>buildReport());
```

### 🔹 File & Streaming Helpers (40+ functions)
- Stream large files, chunked uploads/merges, temporary URLs, hashing, simple encryption/decryption

Example:
```php
return stream_file_response(storage_path('app/big.csv'), 'data.csv');
```

### 🔹 System Monitoring & Optimization (40+ functions)
- CPU/memory/disk/network snapshots, latency timers, simple rate counters

Example:
```php
latency_timer(fn()=>User::count()); // ['ms'=>..., 'result'=>...] 
```

### 🔹 Security & Authentication (40+ functions)
- Tokens, password strength, TOTP 2FA, IP allow/deny, brute‑force guards, session utilities

Example:
```php
$secret = totp_generate_secret();
$code = totp_now($secret);           // '123456'
totp_verify($secret, $code);         // true
```

### 🔹 Advanced Developer Utilities (40+ functions)
- Query tracing, timing, SQL dump, deterministic RNG seed, lightweight HTTP mocks

### 🔹 3rd‑Party API Helpers (40+ functions)
- Retry/backoff, GraphQL helper, HMAC signatures, webhook verify, response masking

### 🔹 SQL Optimization & Data (40+ functions)
- EXPLAIN wrappers, index suggestions, batch insert, raw auto‑pagination, streaming selects

### 🔹 Data Science & Analytics (40+ functions)
- Mean/median/mode/stddev, correlation, linear regression, moving average, exponential smoothing, k‑means, confusion matrix

### 🔹 Frontend Optimization (40+ functions)
- Minify CSS/JS/HTML, inline critical CSS, async/defer scripts, cache‑busting

### 🔹 Spatial, Geohash & Geo‑SQL (501–540)
- Haversine/equirectangular distance, geohash encode/decode, tiles/bbox, polyline encode/decode, DBSCAN clustering, bearings/compass

Example:
```php
geo_haversine_distance(23.02,72.57,23.03,72.58); // meters
geo_point_to_hash(23.02,72.57,7);                // 'tp...'
geo_decode_polyline($polyline);                  // [[lat,lon],...]
```

## 🎨 Blade directives

The package includes custom Blade directives for enhanced templating:

```blade
@ifroute('admin.dashboard')
    <p>Admin Dashboard Content</p>
@endifroute

@ifcontroller('AdminController')
    <p>Admin Controller Content</p>
@endifcontroller

@ifrole('admin')
    <p>Admin Only Content</p>
@endifrole

@ifpermission('edit-posts')
    <p>Edit Posts Permission</p>
@endifpermission
```

## 🔧 Configuration

The package works out of the box with default settings. You can customize behavior by publishing the config file:

```bash
php artisan vendor:publish --provider="Subhashladumor\LaravelHelperbox\HelperServiceProvider"
```

## 📖 More examples

### Array operations
```php
// Flatten nested arrays
$nested = [1, [2, [3, 4]], 5];
$flattened = array_flatten_recursive($nested);
// Result: [1, 2, 3, 4, 5]

// Group by key
$users = [
    ['name' => 'John', 'role' => 'admin'],
    ['name' => 'Jane', 'role' => 'user'],
    ['name' => 'Bob', 'role' => 'admin']
];
$grouped = array_group_by($users, 'role');
// Result: ['admin' => [...], 'user' => [...]]

// Convert to XML
$data = ['name' => 'John', 'age' => 30];
$xml = array_to_xml($data);
```

### String manipulation
```php
// Generate slugs
$slug = str_slugify('Hello World!');
// Result: 'hello-world'

// Convert cases
$camel = str_to_camel_case('hello_world');
// Result: 'helloWorld'

// Mask sensitive data
$masked = str_mask_middle('1234567890', 3);
// Result: '123****890'
```

### Mathematical operations
```php
// Calculate factorials
$factorial = math_factorial(5);
// Result: 120

// Generate Fibonacci numbers
$fibonacci = math_fibonacci(10);
// Result: 55

// Check prime numbers
$isPrime = math_is_prime(17);
// Result: true
```

### Date & time operations
```php
// Check if date is today
$isToday = date_is_today('2024-01-15');

// Calculate differences
$days = date_diff_in_days('2024-01-01', '2024-01-15');
// Result: 14

// Get relative time
$relative = date_ago('2024-01-01');
// Result: '2 weeks ago'
```

### Database operations
```php
// Check if model exists
$exists = model_exists(User::class, 1);

// Bulk update
$updated = model_bulk_update(User::class, [
    1 => ['status' => 'active'],
    2 => ['status' => 'inactive']
]);

// Get table size
$size = db_table_size('users');
```

### File operations
```php
// Get file MIME type
$mime = file_get_mime('/path/to/file.jpg');
// Result: 'image/jpeg'

// Copy directory recursively
$copied = file_copy_recursive('/source', '/destination');

// Search in files
$matches = file_search('/path/to/file.txt', 'search term');
```

### API responses
```php
// Success response
return api_success($data, 'Operation successful');

// Error response
return api_error('Something went wrong', 400);

// Validation error
return api_validation_error($errors, 'Validation failed');
```

## 🧪 Testing

Run the test suite:

```bash
composer test
```

## 📊 Performance

The package is optimized for performance:
- **Memory Efficient** - Minimal memory footprint
- **Fast Execution** - Optimized algorithms
- **Lazy Loading** - Functions loaded only when needed
- **Caching Ready** - Built-in caching support

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Author

**Subhash Ladumor**
- GitHub: [@subhashladumor](https://github.com/subhashladumor)

## 🙏 Acknowledgments

- Laravel community for the amazing framework
- PHP community for continuous improvements
- All contributors who help make this package better

## 📈 Changelog

### v1.0.0
- Initial release
- 600+ helper functions
- Laravel integration
- Blade directives
- Comprehensive documentation

---

**Made with ❤️ for the Laravel community**
