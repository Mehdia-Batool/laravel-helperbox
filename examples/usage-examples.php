<?php

/**
 * Laravel HelperBox Usage Examples
 * 
 * This file demonstrates how to use the various helper functions
 * provided by the Laravel HelperBox package.
 * 
 * @package Subhashladumor\LaravelHelperbox
 * @author Subhash Ladumor
 */

// ============================================================================
// ARRAY HELPERS EXAMPLES
// ============================================================================

echo "=== ARRAY HELPERS ===\n\n";

// Flatten recursive array
$nestedArray = [1, [2, [3, 4]], 5, [6, [7, [8, 9]]]];
$flattened = array_flatten_recursive($nestedArray);
echo "Flattened array: " . json_encode($flattened) . "\n";

// Group array by key
$users = [
    ['name' => 'John', 'role' => 'admin', 'age' => 30],
    ['name' => 'Jane', 'role' => 'user', 'age' => 25],
    ['name' => 'Bob', 'role' => 'admin', 'age' => 35],
    ['name' => 'Alice', 'role' => 'user', 'age' => 28]
];
$groupedByRole = array_group_by($users, 'role');
echo "Grouped by role: " . json_encode($groupedByRole, JSON_PRETTY_PRINT) . "\n";

// Convert array to XML
$data = ['name' => 'John', 'age' => 30, 'hobbies' => ['reading', 'gaming']];
$xml = array_to_xml($data);
echo "Array to XML:\n" . $xml . "\n";

// Partition array
$numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$partitioned = array_partition($numbers, function($n) { return $n % 2 === 0; });
echo "Partitioned (even/odd): " . json_encode($partitioned) . "\n";

// ============================================================================
// STRING HELPERS EXAMPLES
// ============================================================================

echo "\n=== STRING HELPERS ===\n\n";

// Generate slug
$slug = str_slugify('Hello World! This is a test.');
echo "Slug: " . $slug . "\n";

// Convert to different cases
$text = 'hello_world_example';
echo "Camel case: " . str_to_camel_case($text) . "\n";
echo "Pascal case: " . str_to_pascal_case($text) . "\n";
echo "Kebab case: " . str_to_kebab_case($text) . "\n";

// Mask sensitive data
$creditCard = '1234567890123456';
$masked = str_mask_middle($creditCard, 4);
echo "Masked credit card: " . $masked . "\n";

// Check palindrome
$palindrome = 'racecar';
$isPalindrome = str_is_palindrome($palindrome);
echo "Is '$palindrome' a palindrome? " . ($isPalindrome ? 'Yes' : 'No') . "\n";

// Extract emails from text
$text = 'Contact us at john@example.com or jane@test.org for more info.';
$emails = str_extract_emails($text);
echo "Extracted emails: " . json_encode($emails) . "\n";

// ============================================================================
// MATH HELPERS EXAMPLES
// ============================================================================

echo "\n=== MATH HELPERS ===\n\n";

// Calculate factorial
$factorial = math_factorial(5);
echo "Factorial of 5: " . $factorial . "\n";

// Generate Fibonacci numbers
$fibonacci = math_fibonacci(10);
echo "10th Fibonacci number: " . $fibonacci . "\n";

// Check prime number
$isPrime = math_is_prime(17);
echo "Is 17 prime? " . ($isPrime ? 'Yes' : 'No') . "\n";

// Calculate GCD and LCM
$gcd = math_gcd(48, 18);
$lcm = math_lcm(48, 18);
echo "GCD of 48 and 18: " . $gcd . "\n";
echo "LCM of 48 and 18: " . $lcm . "\n";

// Statistical calculations
$numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
echo "Average: " . math_average($numbers) . "\n";
echo "Median: " . math_median($numbers) . "\n";
echo "Standard deviation: " . math_standard_deviation($numbers) . "\n";

// ============================================================================
// DATE & TIME HELPERS EXAMPLES
// ============================================================================

echo "\n=== DATE & TIME HELPERS ===\n\n";

$date = '2024-01-15';
$today = date('Y-m-d');

// Check if date is today
$isToday = date_is_today($date);
echo "Is '$date' today? " . ($isToday ? 'Yes' : 'No') . "\n";

// Calculate difference in days
$date1 = '2024-01-01';
$date2 = '2024-01-15';
$daysDiff = date_diff_in_days($date1, $date2);
echo "Days between $date1 and $date2: " . $daysDiff . "\n";

// Get relative time
$pastDate = '2024-01-01';
$relative = date_ago($pastDate);
echo "Relative time: " . $relative . "\n";

// Get start and end of week
$weekStart = date_start_of_week($date);
$weekEnd = date_end_of_week($date);
echo "Week start: " . $weekStart->format('Y-m-d') . "\n";
echo "Week end: " . $weekEnd->format('Y-m-d') . "\n";

// ============================================================================
// FILE & PATH HELPERS EXAMPLES
// ============================================================================

echo "\n=== FILE & PATH HELPERS ===\n\n";

// Get file extension
$filename = 'document.pdf';
$extension = file_get_extension($filename);
echo "File extension of '$filename': " . $extension . "\n";

// Generate random filename
$randomName = file_random_name('jpg');
echo "Random filename: " . $randomName . "\n";

// Clean filename
$dirtyName = 'My File (2024) - Final Version!.txt';
$cleanName = file_clean_name($dirtyName);
echo "Cleaned filename: " . $cleanName . "\n";

// ============================================================================
// VALIDATION HELPERS EXAMPLES
// ============================================================================

echo "\n=== VALIDATION HELPERS ===\n\n";

// Validate email
$email = 'test@example.com';
$isValidEmail = validate_email($email);
echo "Is '$email' valid? " . ($isValidEmail ? 'Yes' : 'No') . "\n";

// Validate credit card
$creditCard = '4111111111111111';
$isValidCard = validate_credit_card($creditCard);
echo "Is credit card valid? " . ($isValidCard ? 'Yes' : 'No') . "\n";

// Validate password strength
$password = 'MyStr0ng!Pass';
$isStrongPassword = validate_password_strength($password);
echo "Is password strong? " . ($isStrongPassword ? 'Yes' : 'No') . "\n";

// ============================================================================
// CACHE & SESSION HELPERS EXAMPLES
// ============================================================================

echo "\n=== CACHE & SESSION HELPERS ===\n\n";

// Cache with fallback
$cachedValue = cache_remember_or_default('expensive_calculation', 3600, function() {
    // Simulate expensive calculation
    return math_factorial(10);
}, 'default_value');

echo "Cached value: " . $cachedValue . "\n";

// Session flash messages
session_flash_success('Operation completed successfully!');
session_flash_error('Something went wrong!');
session_flash_warning('Please check your input!');

echo "Flash messages set in session\n";

// ============================================================================
// API & HTTP HELPERS EXAMPLES
// ============================================================================

echo "\n=== API & HTTP HELPERS ===\n\n";

// Validate URL
$url = 'https://example.com/api/users';
$isValidUrl = http_validate_url($url);
echo "Is URL valid? " . ($isValidUrl ? 'Yes' : 'No') . "\n";

// Extract domain from URL
$domain = http_get_domain($url);
echo "Domain: " . $domain . "\n";

// Build query URL
$baseUrl = 'https://api.example.com/search';
$params = ['q' => 'laravel', 'page' => 1, 'limit' => 10];
$queryUrl = http_build_query_url($baseUrl, $params);
echo "Query URL: " . $queryUrl . "\n";

// ============================================================================
// ADVANCED ALGORITHM HELPERS EXAMPLES
// ============================================================================

echo "\n=== ADVANCED ALGORITHM HELPERS ===\n\n";

// Convert array to heap
$numbers = [3, 1, 4, 1, 5, 9, 2, 6];
$maxHeap = array_to_heap($numbers, true);
echo "Max heap: " . json_encode($maxHeap) . "\n";

// Extract max from heap
$max = heap_extract_max($maxHeap);
echo "Max value: " . $max . "\n";

// Build trie
$trie = [];
$words = ['cat', 'car', 'card', 'care', 'careful'];
foreach ($words as $word) {
    trie_insert($trie, $word);
}

// Search in trie
$found = trie_search($trie, 'car');
echo "Is 'car' in trie? " . ($found ? 'Yes' : 'No') . "\n";

// Prefix search
$prefixWords = trie_prefix_search($trie, 'car');
echo "Words with prefix 'car': " . json_encode($prefixWords) . "\n";

// ============================================================================
// MEMORY & SYSTEM HELPERS EXAMPLES
// ============================================================================

echo "\n=== MEMORY & SYSTEM HELPERS ===\n\n";

// Get memory usage
$memoryUsage = memory_usage_human();
echo "Current memory usage: " . $memoryUsage . "\n";

// Get system uptime
$uptime = system_uptime_human();
echo "System uptime: " . $uptime . "\n";

// Get PHP version
$phpVersion = system_php_version();
echo "PHP version: " . $phpVersion . "\n";

// System health check
$health = system_health_check();
echo "System health: " . ($health['overall_ok'] ? 'OK' : 'Issues detected') . "\n";

// ============================================================================
// CONTROLLER & REPOSITORY HELPERS EXAMPLES
// ============================================================================

echo "\n=== CONTROLLER & REPOSITORY HELPERS ===\n\n";

// Get current controller action
$action = controller_action_name();
echo "Current action: " . $action . "\n";

// Get controller class name
$controller = controller_class_name();
echo "Current controller: " . $controller . "\n";

// Check if controller has method
$hasMethod = controller_has_method('App\Http\Controllers\UserController', 'index');
echo "Does UserController have 'index' method? " . ($hasMethod ? 'Yes' : 'No') . "\n";

echo "\n=== EXAMPLES COMPLETED ===\n";
