# Laravel HelperBox - Complete Function Reference

This document provides comprehensive documentation for all 600+ helper functions in the Laravel HelperBox package, organized by category with detailed examples and usage instructions.

## Table of Contents

1. [Array Helpers](#array-helpers)
2. [String Helpers](#string-helpers)
3. [Math Helpers](#math-helpers)
4. [Blade Helpers](#blade-helpers)
5. [Model & Database Helpers](#model--database-helpers)
6. [File & Path Helpers](#file--path-helpers)
7. [Memory & System Helpers](#memory--system-helpers)
8. [Controller & Repository Helpers](#controller--repository-helpers)
9. [Date & Time Helpers](#date--time-helpers)
10. [Cache & Session Helpers](#cache--session-helpers)
11. [API & HTTP Helpers](#api--http-helpers)
12. [Validation Helpers](#validation-helpers)
13. [Advanced Algorithm Helpers](#advanced-algorithm-helpers)
14. [Advanced String & Parsing Helpers](#advanced-string--parsing-helpers)
15. [Advanced Math & Algorithmic Helpers](#advanced-math--algorithmic-helpers)

---

## Array Helpers

### `array_flatten_recursive($array, $depth = 0)`

Flattens a multi-dimensional array recursively.

**Parameters:**
- `$array` (array): The array to flatten
- `$depth` (int): Maximum depth to flatten (0 = unlimited)

**Returns:** `array` - Flattened array

**Example:**
```php
$nested = [1, [2, [3, 4]], 5, [6, [7, [8, 9]]]];
$flattened = array_flatten_recursive($nested);
// Result: [1, 2, 3, 4, 5, 6, 7, 8, 9]

// With depth limit
$limited = array_flatten_recursive($nested, 2);
// Result: [1, 2, [3, 4], 5, 6, [7, [8, 9]]]
```

### `array_to_xml($array, $rootElement = 'root', $xmlVersion = '1.0', $encoding = 'UTF-8')`

Converts an array into XML format.

**Parameters:**
- `$array` (array): The array to convert
- `$rootElement` (string): Root element name
- `$xmlVersion` (string): XML version
- `$encoding` (string): XML encoding

**Returns:** `string` - XML string

**Example:**
```php
$data = [
    'name' => 'John Doe',
    'age' => 30,
    'hobbies' => ['reading', 'gaming', 'coding'],
    'address' => [
        'street' => '123 Main St',
        'city' => 'New York',
        'zip' => '10001'
    ]
];

$xml = array_to_xml($data, 'person');
echo $xml;
```

**Output:**
```xml
<?xml version="1.0" encoding="UTF-8"?>
<person>
    <name>John Doe</name>
    <age>30</age>
    <hobbies>
        <item>reading</item>
        <item>gaming</item>
        <item>coding</item>
    </hobbies>
    <address>
        <street>123 Main St</street>
        <city>New York</city>
        <zip>10001</zip>
    </address>
</person>
```

### `array_group_by($array, $key)`

Groups an array of items by a key or callback.

**Parameters:**
- `$array` (array): The array to group
- `$key` (string|callable): Key to group by or callback function

**Returns:** `array` - Grouped array

**Example:**
```php
$users = [
    ['name' => 'John', 'role' => 'admin', 'age' => 30],
    ['name' => 'Jane', 'role' => 'user', 'age' => 25],
    ['name' => 'Bob', 'role' => 'admin', 'age' => 35],
    ['name' => 'Alice', 'role' => 'user', 'age' => 28]
];

// Group by role
$groupedByRole = array_group_by($users, 'role');
// Result: ['admin' => [...], 'user' => [...]]

// Group by callback
$groupedByAge = array_group_by($users, function($user) {
    return $user['age'] >= 30 ? 'senior' : 'junior';
});
// Result: ['senior' => [...], 'junior' => [...]]
```

### `array_multi_search($array, $search, $strict = false)`

Searches recursively for a value in multi-dimensional array.

**Parameters:**
- `$array` (array): The array to search
- `$search` (mixed): The value to search for
- `$strict` (bool): Whether to use strict comparison

**Returns:** `array` - Array of paths where the value was found

**Example:**
```php
$data = [
    'users' => [
        ['name' => 'John', 'age' => 30],
        ['name' => 'Jane', 'age' => 25]
    ],
    'products' => [
        ['name' => 'Laptop', 'price' => 1000],
        ['name' => 'Mouse', 'price' => 25]
    ]
];

$paths = array_multi_search($data, 'John');
// Result: [['users', 0, 'name']]

$paths = array_multi_search($data, 25);
// Result: [['users', 1, 'age'], ['products', 1, 'price']]
```

### `array_partition($array, $callback)`

Partition array into two groups based on condition.

**Parameters:**
- `$array` (array): The array to partition
- `$callback` (callable): The condition callback

**Returns:** `array` - Array with 'true' and 'false' keys

**Example:**
```php
$numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$partitioned = array_partition($numbers, function($n) {
    return $n % 2 === 0;
});

// Result: [
//     'true' => [2, 4, 6, 8, 10],
//     'false' => [1, 3, 5, 7, 9]
// ]
```

---

## String Helpers

### `str_slugify($string, $separator = '-')`

Generate URL slug from string.

**Parameters:**
- `$string` (string): The string to slugify
- `$separator` (string): Separator character

**Returns:** `string` - URL slug

**Example:**
```php
$slug = str_slugify('Hello World! This is a test.');
// Result: 'hello-world-this-is-a-test'

$slug = str_slugify('Special Characters @#$%', '_');
// Result: 'special_characters'
```

### `str_to_camel_case($string)`

Convert string to camelCase.

**Parameters:**
- `$string` (string): The string to convert

**Returns:** `string` - camelCase string

**Example:**
```php
$camel = str_to_camel_case('hello_world_example');
// Result: 'helloWorldExample'

$camel = str_to_camel_case('Hello World Example');
// Result: 'helloWorldExample'
```

### `str_mask_middle($string, $visible, $mask = '*')`

Mask middle part of sensitive string.

**Parameters:**
- `$string` (string): The string to mask
- `$visible` (int): Number of characters to keep visible at each end
- `$mask` (string): Character to use for masking

**Returns:** `string` - Masked string

**Example:**
```php
$creditCard = '1234567890123456';
$masked = str_mask_middle($creditCard, 4);
// Result: '1234********3456'

$email = 'john.doe@example.com';
$masked = str_mask_middle($email, 2);
// Result: 'jo****@example.com'
```

### `str_levenshtein_distance($string1, $string2)`

Calculate Levenshtein distance between two strings.

**Parameters:**
- `$string1` (string): First string
- `$string2` (string): Second string

**Returns:** `int` - Levenshtein distance

**Example:**
```php
$distance = str_levenshtein_distance('kitten', 'sitting');
// Result: 3

$distance = str_levenshtein_distance('hello', 'world');
// Result: 4
```

### `str_extract_emails($string)`

Extract email addresses from string.

**Parameters:**
- `$string` (string): The string to search

**Returns:** `array` - Array of email addresses

**Example:**
```php
$text = 'Contact us at john@example.com or jane@test.org for more info.';
$emails = str_extract_emails($text);
// Result: ['john@example.com', 'jane@test.org']
```

---

## Math Helpers

### `math_factorial($n)`

Calculate factorial of a number.

**Parameters:**
- `$n` (int): The number to calculate factorial for

**Returns:** `int|float` - Factorial result

**Example:**
```php
$factorial = math_factorial(5);
// Result: 120

$factorial = math_factorial(10);
// Result: 3628800
```

### `math_fibonacci($n)`

Get nth Fibonacci number.

**Parameters:**
- `$n` (int): Position in Fibonacci sequence

**Returns:** `int` - Fibonacci number

**Example:**
```php
$fib = math_fibonacci(10);
// Result: 55

$fib = math_fibonacci(20);
// Result: 6765
```

### `math_is_prime($n)`

Check if number is prime.

**Parameters:**
- `$n` (int): The number to check

**Returns:** `bool` - True if prime

**Example:**
```php
$isPrime = math_is_prime(17);
// Result: true

$isPrime = math_is_prime(15);
// Result: false
```

### `math_gcd($a, $b)`

Calculate greatest common divisor.

**Parameters:**
- `$a` (int): First number
- `$b` (int): Second number

**Returns:** `int` - GCD

**Example:**
```php
$gcd = math_gcd(48, 18);
// Result: 6

$gcd = math_gcd(100, 25);
// Result: 25
```

### `math_standard_deviation($array, $sample = false)`

Calculate standard deviation.

**Parameters:**
- `$array` (array): Array of numbers
- `$sample` (bool): Whether to calculate sample standard deviation

**Returns:** `float` - Standard deviation

**Example:**
```php
$numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$stdDev = math_standard_deviation($numbers);
// Result: 3.0276503540974917

$stdDev = math_standard_deviation($numbers, true);
// Result: 3.1622776601683795
```

---

## Blade Helpers

### `blade_if_route($route)`

Check if current route matches given route name.

**Parameters:**
- `$route` (string|array): Route name or array of route names

**Returns:** `bool` - True if current route matches

**Example:**
```blade
@ifroute('admin.dashboard')
    <p>Admin Dashboard Content</p>
@endifroute

@ifroute(['admin.dashboard', 'admin.users'])
    <p>Admin Section Content</p>
@endifroute
```

### `blade_if_role($role)`

Check if current user has given role.

**Parameters:**
- `$role` (string|array): Role name or array of role names

**Returns:** `bool` - True if user has role

**Example:**
```blade
@ifrole('admin')
    <p>Admin Only Content</p>
@endifrole

@ifrole(['admin', 'moderator'])
    <p>Admin or Moderator Content</p>
@endifrole
```

### `blade_format_date($date, $format)`

Format date for Blade templates.

**Parameters:**
- `$date` (mixed): Date to format
- `$format` (string): Date format

**Returns:** `string` - Formatted date

**Example:**
```blade
{{ blade_format_date($user->created_at, 'M j, Y') }}
<!-- Result: Jan 15, 2024 -->

{{ blade_format_date($post->published_at, 'F j, Y \a\t g:i A') }}
<!-- Result: January 15, 2024 at 2:30 PM -->
```

### `blade_asset_version($file)`

Append file version hash to asset URL.

**Parameters:**
- `$file` (string): Asset file path

**Returns:** `string` - Asset URL with version

**Example:**
```blade
<link rel="stylesheet" href="{{ blade_asset_version('css/app.css') }}">
<!-- Result: /css/app.css?v=1640995200 -->

<script src="{{ blade_asset_version('js/app.js') }}"></script>
<!-- Result: /js/app.js?v=1640995200 -->
```

---

## Model & Database Helpers

### `model_exists($model, $id)`

Check if model record exists.

**Parameters:**
- `$model` (string): Model class name
- `$id` (mixed): Record ID

**Returns:** `bool` - True if record exists

**Example:**
```php
$exists = model_exists(User::class, 1);
// Result: true

$exists = model_exists(Post::class, 999);
// Result: false
```

### `model_bulk_update($model, $updates)`

Bulk update model records.

**Parameters:**
- `$model` (string): Model class name
- `$updates` (array): Array of updates with IDs

**Returns:** `int` - Number of updated records

**Example:**
```php
$updated = model_bulk_update(User::class, [
    1 => ['status' => 'active'],
    2 => ['status' => 'inactive'],
    3 => ['last_login' => now()]
]);
// Result: 3 (number of updated records)
```

### `db_table_size($table)`

Get table size in bytes.

**Parameters:**
- `$table` (string): Table name

**Returns:** `int` - Table size in bytes

**Example:**
```php
$size = db_table_size('users');
// Result: 1048576 (1MB)

$size = db_table_size('posts');
// Result: 5242880 (5MB)
```

### `db_optimize_table($table)`

Optimize database table.

**Parameters:**
- `$table` (string): Table name

**Returns:** `bool` - True if successful

**Example:**
```php
$optimized = db_optimize_table('users');
// Result: true

$optimized = db_optimize_table('posts');
// Result: true
```

---

## File & Path Helpers

### `file_get_mime($path)`

Detect MIME type of file.

**Parameters:**
- `$path` (string): File path

**Returns:** `string` - MIME type

**Example:**
```php
$mime = file_get_mime('/path/to/image.jpg');
// Result: 'image/jpeg'

$mime = file_get_mime('/path/to/document.pdf');
// Result: 'application/pdf'
```

### `file_size_human($path)`

Get human-readable file size.

**Parameters:**
- `$path` (string): File path

**Returns:** `string` - Human-readable size

**Example:**
```php
$size = file_size_human('/path/to/large-file.zip');
// Result: '2.5 MB'

$size = file_size_human('/path/to/small-file.txt');
// Result: '1.2 KB'
```

### `file_copy_recursive($from, $to)`

Copy directory recursively.

**Parameters:**
- `$from` (string): Source directory
- `$to` (string): Destination directory

**Returns:** `bool` - True if successful

**Example:**
```php
$copied = file_copy_recursive('/source/directory', '/destination/directory');
// Result: true

$copied = file_copy_recursive('/uploads', '/backup/uploads');
// Result: true
```

### `file_search($path, $search, $caseSensitive = false)`

Search text inside file.

**Parameters:**
- `$path` (string): File path
- `$search` (string): Search term
- `$caseSensitive` (bool): Case sensitive search

**Returns:** `array` - Array of matching lines

**Example:**
```php
$matches = file_search('/path/to/logfile.log', 'ERROR');
// Result: [
//     ['line' => 15, 'content' => 'ERROR: Database connection failed'],
//     ['line' => 23, 'content' => 'ERROR: File not found']
// ]
```

---

## Memory & System Helpers

### `memory_usage($realUsage = false)`

Get current memory usage.

**Parameters:**
- `$realUsage` (bool): Whether to get real memory usage

**Returns:** `int` - Memory usage in bytes

**Example:**
```php
$usage = memory_usage();
// Result: 2097152 (2MB)

$realUsage = memory_usage(true);
// Result: 3145728 (3MB)
```

### `memory_usage_human($realUsage = false)`

Get current memory usage in human-readable format.

**Parameters:**
- `$realUsage` (bool): Whether to get real memory usage

**Returns:** `string` - Human-readable memory usage

**Example:**
```php
$usage = memory_usage_human();
// Result: '2.0 MB'

$realUsage = memory_usage_human(true);
// Result: '3.0 MB'
```

### `system_uptime()`

Get system uptime.

**Returns:** `int` - System uptime in seconds

**Example:**
```php
$uptime = system_uptime();
// Result: 86400 (1 day)

$uptime = system_uptime();
// Result: 604800 (1 week)
```

### `system_health_check()`

Perform basic system health check.

**Returns:** `array` - Health check results

**Example:**
```php
$health = system_health_check();
// Result: [
//     'memory_ok' => true,
//     'memory_usage' => 45.2,
//     'cpu_ok' => true,
//     'cpu_load' => 1.2,
//     'disk_ok' => true,
//     'disk_usage' => 75.8,
//     'overall_ok' => true
// ]
```

---

## Date & Time Helpers

### `date_is_today($date)`

Check if date is today.

**Parameters:**
- `$date` (mixed): Date to check

**Returns:** `bool` - True if today

**Example:**
```php
$isToday = date_is_today('2024-01-15');
// Result: true (if today is 2024-01-15)

$isToday = date_is_today('2024-01-14');
// Result: false
```

### `date_diff_in_days($date1, $date2)`

Calculate days difference between two dates.

**Parameters:**
- `$date1` (mixed): First date
- `$date2` (mixed): Second date

**Returns:** `int` - Days difference

**Example:**
```php
$days = date_diff_in_days('2024-01-01', '2024-01-15');
// Result: 14

$days = date_diff_in_days('2024-01-15', '2024-01-01');
// Result: 14
```

### `date_ago($date)`

Get "time ago" format for date.

**Parameters:**
- `$date` (mixed): Date

**Returns:** `string` - Time ago string

**Example:**
```php
$ago = date_ago('2024-01-01');
// Result: '2 weeks ago'

$ago = date_ago('2024-01-14 10:30:00');
// Result: '1 hour ago'
```

### `date_get_working_days($startDate, $endDate)`

Get number of working days between two dates.

**Parameters:**
- `$startDate` (mixed): Start date
- `$endDate` (mixed): End date

**Returns:** `int` - Number of working days

**Example:**
```php
$workingDays = date_get_working_days('2024-01-01', '2024-01-15');
// Result: 11 (excluding weekends)

$workingDays = date_get_working_days('2024-01-01', '2024-01-07');
// Result: 5 (Monday to Friday)
```

---

## Cache & Session Helpers

### `cache_has_or_store($key, $callback, $seconds)`

Store value in cache if key doesn't exist.

**Parameters:**
- `$key` (string): Cache key
- `$callback` (callable): Callback to generate value
- `$seconds` (int): TTL in seconds

**Returns:** `mixed` - Cached value

**Example:**
```php
$expensiveData = cache_has_or_store('expensive_calculation', function() {
    // Expensive operation
    return math_factorial(100);
}, 3600);

// Result: Cached factorial result
```

### `cache_increment($key, $value = 1)`

Increment cache value.

**Parameters:**
- `$key` (string): Cache key
- `$value` (int): Value to increment by

**Returns:** `int` - New value

**Example:**
```php
$count = cache_increment('page_views');
// Result: 1

$count = cache_increment('page_views', 5);
// Result: 6
```

### `session_flash_success($message)`

Flash success message to session.

**Parameters:**
- `$message` (string): Success message

**Returns:** `void`

**Example:**
```php
session_flash_success('User created successfully!');
// Message will be available in next request
```

### `session_flash_error($message)`

Flash error message to session.

**Parameters:**
- `$message` (string): Error message

**Returns:** `void`

**Example:**
```php
session_flash_error('Failed to create user!');
// Error message will be available in next request
```

---

## API & HTTP Helpers

### `http_get_json($url, $headers = [])`

Make GET request and return JSON response.

**Parameters:**
- `$url` (string): Request URL
- `$headers` (array): HTTP headers

**Returns:** `array|false` - JSON response or false on error

**Example:**
```php
$response = http_get_json('https://api.example.com/users');
// Result: ['users' => [...], 'total' => 100]

$response = http_get_json('https://api.example.com/users', [
    'Authorization' => 'Bearer token123'
]);
// Result: ['users' => [...], 'total' => 100]
```

### `http_post_json($url, $data, $headers = [])`

Make POST request with JSON data.

**Parameters:**
- `$url` (string): Request URL
- `$data` (array): Request data
- `$headers` (array): HTTP headers

**Returns:** `array|false` - JSON response or false on error

**Example:**
```php
$response = http_post_json('https://api.example.com/users', [
    'name' => 'John Doe',
    'email' => 'john@example.com'
]);
// Result: ['id' => 123, 'name' => 'John Doe', 'email' => 'john@example.com']
```

### `api_success($data, $message, $code)`

Create success API response.

**Parameters:**
- `$data` (mixed): Response data
- `$message` (string): Success message
- `$code` (int): HTTP status code

**Returns:** `\Illuminate\Http\JsonResponse`

**Example:**
```php
return api_success($user, 'User created successfully', 201);
// Result: JSON response with success structure
```

### `api_error($message, $code, $errors)`

Create error API response.

**Parameters:**
- `$message` (string): Error message
- `$code` (int): HTTP status code
- `$errors` (mixed): Additional error details

**Returns:** `\Illuminate\Http\JsonResponse`

**Example:**
```php
return api_error('Validation failed', 422, $validationErrors);
// Result: JSON response with error structure
```

---

## Validation Helpers

### `validate_email($email)`

Validate email address.

**Parameters:**
- `$email` (string): Email to validate

**Returns:** `bool` - True if valid

**Example:**
```php
$isValid = validate_email('test@example.com');
// Result: true

$isValid = validate_email('invalid-email');
// Result: false
```

### `validate_credit_card($number)`

Validate credit card number using Luhn algorithm.

**Parameters:**
- `$number` (string): Credit card number

**Returns:** `bool` - True if valid

**Example:**
```php
$isValid = validate_credit_card('4111111111111111');
// Result: true

$isValid = validate_credit_card('1234567890123456');
// Result: false
```

### `validate_password_strength($password, $minLength)`

Validate password strength.

**Parameters:**
- `$password` (string): Password to validate
- `$minLength` (int): Minimum length

**Returns:** `bool` - True if strong enough

**Example:**
```php
$isStrong = validate_password_strength('MyStr0ng!Pass', 8);
// Result: true

$isStrong = validate_password_strength('weak', 8);
// Result: false
```

### `sanitize_string($string, $allowed)`

Sanitize string by removing unwanted characters.

**Parameters:**
- `$string` (string): String to sanitize
- `$allowed` (string): Allowed characters pattern

**Returns:** `string` - Sanitized string

**Example:**
```php
$clean = sanitize_string('Hello@#$%World!', 'a-zA-Z0-9\s');
// Result: 'HelloWorld'

$clean = sanitize_string('User123!@#', 'a-zA-Z0-9');
// Result: 'User123'
```

---

## Advanced Algorithm Helpers

### `array_to_heap($array, $maxHeap = true)`

Convert array into a min-heap or max-heap structure.

**Parameters:**
- `$array` (array): Array to convert
- `$maxHeap` (bool): True for max-heap, false for min-heap

**Returns:** `array` - Heap structure

**Example:**
```php
$numbers = [3, 1, 4, 1, 5, 9, 2, 6];
$maxHeap = array_to_heap($numbers, true);
// Result: [9, 6, 4, 1, 5, 1, 2, 3]

$minHeap = array_to_heap($numbers, false);
// Result: [1, 1, 2, 3, 5, 9, 4, 6]
```

### `graph_shortest_path($graph, $start, $end)`

Find shortest path using Dijkstra's algorithm.

**Parameters:**
- `$graph` (array): Adjacency list representation
- `$start` (mixed): Start vertex
- `$end` (mixed): End vertex

**Returns:** `array|false` - Shortest path or false

**Example:**
```php
$graph = [
    'A' => ['B' => 4, 'C' => 2],
    'B' => ['C' => 1, 'D' => 5],
    'C' => ['D' => 8, 'E' => 10],
    'D' => ['E' => 2],
    'E' => []
];

$path = graph_shortest_path($graph, 'A', 'E');
// Result: ['A', 'C', 'D', 'E']
```

### `trie_insert($trie, $word)`

Insert word into trie.

**Parameters:**
- `$trie` (array): Trie structure
- `$word` (string): Word to insert

**Returns:** `void`

**Example:**
```php
$trie = [];
trie_insert($trie, 'cat');
trie_insert($trie, 'car');
trie_insert($trie, 'card');

$found = trie_search($trie, 'car');
// Result: true
```

---

## Advanced String & Parsing Helpers

### `string_compress_rle($string)`

Run-length encoding compression.

**Parameters:**
- `$string` (string): String to compress

**Returns:** `string` - Compressed string

**Example:**
```php
$compressed = string_compress_rle('AAABBBCCCDDD');
// Result: '3A3B3C3D'

$decompressed = string_decompress_rle($compressed);
// Result: 'AAABBBCCCDDD'
```

### `string_kmp_search($string, $pattern)`

Knuth-Morris-Pratt pattern search.

**Parameters:**
- `$string` (string): Text to search in
- `$pattern` (string): Pattern to search for

**Returns:** `array` - Array of positions where pattern is found

**Example:**
```php
$positions = string_kmp_search('ABABDABACDABABCABAB', 'ABABCABAB');
// Result: [10]

$positions = string_kmp_search('hello world hello', 'hello');
// Result: [0, 12]
```

### `string_longest_palindrome($string)`

Find longest palindromic substring.

**Parameters:**
- `$string` (string): Input string

**Returns:** `string` - Longest palindrome

**Example:**
```php
$palindrome = string_longest_palindrome('babad');
// Result: 'bab'

$palindrome = string_longest_palindrome('cbbd');
// Result: 'bb'
```

---

## Advanced Math & Algorithmic Helpers

### `math_gcd_extended($a, $b)`

Extended Euclidean algorithm.

**Parameters:**
- `$a` (int): First number
- `$b` (int): Second number

**Returns:** `array` - Array with gcd, x, y coefficients

**Example:**
```php
$result = math_gcd_extended(56, 15);
// Result: ['gcd' => 1, 'x' => -4, 'y' => 15]

$result = math_gcd_extended(48, 18);
// Result: ['gcd' => 6, 'x' => -1, 'y' => 3]
```

### `math_fibonacci_matrix($n)`

Fibonacci using matrix exponentiation.

**Parameters:**
- `$n` (int): Position in Fibonacci sequence

**Returns:** `int` - Fibonacci number

**Example:**
```php
$fib = math_fibonacci_matrix(10);
// Result: 55

$fib = math_fibonacci_matrix(100);
// Result: 354224848179261915075
```

### `math_knapsack($weights, $values, $capacity)`

Solve 0/1 knapsack problem.

**Parameters:**
- `$weights` (array): Item weights
- `$values` (array): Item values
- `$capacity` (int): Knapsack capacity

**Returns:** `array` - Maximum value and selected items

**Example:**
```php
$result = math_knapsack([10, 20, 30], [60, 100, 120], 50);
// Result: [
//     'max_value' => 220,
//     'selected_items' => [0, 2]
// ]
```

---

This comprehensive function reference covers all the major helper functions in the Laravel HelperBox package. Each function includes detailed parameter descriptions, return types, and practical examples to help you understand and use them effectively in your Laravel applications.

For more examples and advanced usage patterns, please refer to the `examples/usage-examples.php` file included in the package.
