<?php

/**
 * Validation Helper Functions
 * 
 * This file contains 20+ advanced validation utility functions
 * for data validation, format checking, and input sanitization.
 * 
 * @package Subhashladumor\LaravelHelperbox
 * @author Subhash Ladumor
 */

if (!function_exists('validate_email')) {
    /**
     * Validate email address
     * 
     * @param string $email Email to validate
     * @return bool True if valid
     */
    function validate_email(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}

if (!function_exists('validate_url')) {
    /**
     * Validate URL format
     * 
     * @param string $url URL to validate
     * @return bool True if valid
     */
    function validate_url(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
}

if (!function_exists('validate_ip')) {
    /**
     * Validate IP address
     * 
     * @param string $ip IP to validate
     * @return bool True if valid
     */
    function validate_ip(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }
}

if (!function_exists('validate_ipv4')) {
    /**
     * Validate IPv4 address
     * 
     * @param string $ip IP to validate
     * @return bool True if valid IPv4
     */
    function validate_ipv4(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }
}

if (!function_exists('validate_ipv6')) {
    /**
     * Validate IPv6 address
     * 
     * @param string $ip IP to validate
     * @return bool True if valid IPv6
     */
    function validate_ipv6(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }
}

if (!function_exists('validate_json')) {
    /**
     * Validate JSON string
     * 
     * @param string $json JSON string to validate
     * @return bool True if valid
     */
    function validate_json(string $json): bool
    {
        json_decode($json);
        return json_last_error() === JSON_ERROR_NONE;
    }
}

if (!function_exists('validate_uuid')) {
    /**
     * Validate UUID format
     * 
     * @param string $uuid UUID to validate
     * @return bool True if valid
     */
    function validate_uuid(string $uuid): bool
    {
        return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $uuid) === 1;
    }
}

if (!function_exists('validate_base64')) {
    /**
     * Validate Base64 string
     * 
     * @param string $string String to validate
     * @return bool True if valid
     */
    function validate_base64(string $string): bool
    {
        return base64_encode(base64_decode($string, true)) === $string;
    }
}

if (!function_exists('validate_phone')) {
    /**
     * Validate phone number
     * 
     * @param string $number Phone number
     * @param string|null $country Country code
     * @return bool True if valid
     */
    function validate_phone(string $number, ?string $country = null): bool
    {
        $pattern = '/^[\+]?[1-9]?[0-9]{7,15}$/';
        return preg_match($pattern, $number) === 1;
    }
}

if (!function_exists('validate_credit_card')) {
    /**
     * Validate credit card number using Luhn algorithm
     * 
     * @param string $number Credit card number
     * @return bool True if valid
     */
    function validate_credit_card(string $number): bool
    {
        $number = preg_replace('/\D/', '', $number);
        
        if (strlen($number) < 13 || strlen($number) > 19) {
            return false;
        }
        
        $sum = 0;
        $alternate = false;
        
        for ($i = strlen($number) - 1; $i >= 0; $i--) {
            $digit = (int) $number[$i];
            
            if ($alternate) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit = ($digit % 10) + 1;
                }
            }
            
            $sum += $digit;
            $alternate = !$alternate;
        }
        
        return $sum % 10 === 0;
    }
}

if (!function_exists('validate_password_strength')) {
    /**
     * Validate password strength
     * 
     * @param string $password Password to validate
     * @param int $minLength Minimum length
     * @return bool True if strong enough
     */
    function validate_password_strength(string $password, int $minLength = 8): bool
    {
        if (strlen($password) < $minLength) {
            return false;
        }
        
        $hasUppercase = preg_match('/[A-Z]/', $password);
        $hasLowercase = preg_match('/[a-z]/', $password);
        $hasNumbers = preg_match('/[0-9]/', $password);
        $hasSpecial = preg_match('/[^A-Za-z0-9]/', $password);
        
        return $hasUppercase && $hasLowercase && $hasNumbers && $hasSpecial;
    }
}

if (!function_exists('validate_date_format')) {
    /**
     * Validate date format
     * 
     * @param string $date Date string
     * @param string $format Date format
     * @return bool True if valid
     */
    function validate_date_format(string $date, string $format = 'Y-m-d'): bool
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}

if (!function_exists('validate_time_format')) {
    /**
     * Validate time format
     * 
     * @param string $time Time string
     * @param string $format Time format
     * @return bool True if valid
     */
    function validate_time_format(string $time, string $format = 'H:i:s'): bool
    {
        $d = DateTime::createFromFormat($format, $time);
        return $d && $d->format($format) === $time;
    }
}

if (!function_exists('validate_alpha')) {
    /**
     * Validate alphabetic characters only
     * 
     * @param string $string String to validate
     * @return bool True if valid
     */
    function validate_alpha(string $string): bool
    {
        return ctype_alpha($string);
    }
}

if (!function_exists('validate_alnum')) {
    /**
     * Validate alphanumeric characters only
     * 
     * @param string $string String to validate
     * @return bool True if valid
     */
    function validate_alnum(string $string): bool
    {
        return ctype_alnum($string);
    }
}

if (!function_exists('validate_digit')) {
    /**
     * Validate digits only
     * 
     * @param string $string String to validate
     * @return bool True if valid
     */
    function validate_digit(string $string): bool
    {
        return ctype_digit($string);
    }
}

if (!function_exists('validate_hex')) {
    /**
     * Validate hexadecimal characters only
     * 
     * @param string $string String to validate
     * @return bool True if valid
     */
    function validate_hex(string $string): bool
    {
        return ctype_xdigit($string);
    }
}

if (!function_exists('validate_ascii')) {
    /**
     * Validate ASCII characters only
     * 
     * @param string $string String to validate
     * @return bool True if valid
     */
    function validate_ascii(string $string): bool
    {
        return mb_check_encoding($string, 'ASCII');
    }
}

if (!function_exists('validate_utf8')) {
    /**
     * Validate UTF-8 encoding
     * 
     * @param string $string String to validate
     * @return bool True if valid
     */
    function validate_utf8(string $string): bool
    {
        return mb_check_encoding($string, 'UTF-8');
    }
}

if (!function_exists('validate_length')) {
    /**
     * Validate string length
     * 
     * @param string $string String to validate
     * @param int $min Minimum length
     * @param int $max Maximum length
     * @return bool True if valid
     */
    function validate_length(string $string, int $min = 0, int $max = PHP_INT_MAX): bool
    {
        $length = strlen($string);
        return $length >= $min && $length <= $max;
    }
}

if (!function_exists('validate_range')) {
    /**
     * Validate numeric range
     * 
     * @param mixed $value Value to validate
     * @param int|float $min Minimum value
     * @param int|float $max Maximum value
     * @return bool True if valid
     */
    function validate_range($value, $min, $max): bool
    {
        return is_numeric($value) && $value >= $min && $value <= $max;
    }
}

if (!function_exists('validate_in_array')) {
    /**
     * Validate value is in array
     * 
     * @param mixed $value Value to validate
     * @param array $array Array to check against
     * @return bool True if valid
     */
    function validate_in_array($value, array $array): bool
    {
        return in_array($value, $array);
    }
}

if (!function_exists('validate_not_in_array')) {
    /**
     * Validate value is not in array
     * 
     * @param mixed $value Value to validate
     * @param array $array Array to check against
     * @return bool True if valid
     */
    function validate_not_in_array($value, array $array): bool
    {
        return !in_array($value, $array);
    }
}

if (!function_exists('validate_regex')) {
    /**
     * Validate string against regex pattern
     * 
     * @param string $string String to validate
     * @param string $pattern Regex pattern
     * @return bool True if valid
     */
    function validate_regex(string $string, string $pattern): bool
    {
        return preg_match($pattern, $string) === 1;
    }
}

if (!function_exists('validate_file_extension')) {
    /**
     * Validate file extension
     * 
     * @param string $filename Filename
     * @param array $allowedExtensions Allowed extensions
     * @return bool True if valid
     */
    function validate_file_extension(string $filename, array $allowedExtensions): bool
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($extension, $allowedExtensions);
    }
}

if (!function_exists('validate_file_size')) {
    /**
     * Validate file size
     * 
     * @param string $filePath File path
     * @param int $maxSize Maximum size in bytes
     * @return bool True if valid
     */
    function validate_file_size(string $filePath, int $maxSize): bool
    {
        return file_exists($filePath) && filesize($filePath) <= $maxSize;
    }
}

if (!function_exists('validate_image_dimensions')) {
    /**
     * Validate image dimensions
     * 
     * @param string $filePath Image file path
     * @param int $maxWidth Maximum width
     * @param int $maxHeight Maximum height
     * @return bool True if valid
     */
    function validate_image_dimensions(string $filePath, int $maxWidth, int $maxHeight): bool
    {
        if (!file_exists($filePath)) {
            return false;
        }
        
        $imageInfo = getimagesize($filePath);
        if (!$imageInfo) {
            return false;
        }
        
        return $imageInfo[0] <= $maxWidth && $imageInfo[1] <= $maxHeight;
    }
}

if (!function_exists('sanitize_string')) {
    /**
     * Sanitize string by removing unwanted characters
     * 
     * @param string $string String to sanitize
     * @param string $allowed Allowed characters pattern
     * @return string Sanitized string
     */
    function sanitize_string(string $string, string $allowed = 'a-zA-Z0-9\s'): string
    {
        return preg_replace("/[^{$allowed}]/", '', $string);
    }
}

if (!function_exists('sanitize_html')) {
    /**
     * Sanitize HTML string
     * 
     * @param string $html HTML string
     * @param string $allowedTags Allowed HTML tags
     * @return string Sanitized HTML
     */
    function sanitize_html(string $html, string $allowedTags = ''): string
    {
        return strip_tags($html, $allowedTags);
    }
}

if (!function_exists('sanitize_email')) {
    /**
     * Sanitize email address
     * 
     * @param string $email Email to sanitize
     * @return string Sanitized email
     */
    function sanitize_email(string $email): string
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }
}

if (!function_exists('sanitize_url')) {
    /**
     * Sanitize URL
     * 
     * @param string $url URL to sanitize
     * @return string Sanitized URL
     */
    function sanitize_url(string $url): string
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }
}

if (!function_exists('sanitize_int')) {
    /**
     * Sanitize integer
     * 
     * @param mixed $value Value to sanitize
     * @return int Sanitized integer
     */
    function sanitize_int($value): int
    {
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }
}

if (!function_exists('sanitize_float')) {
    /**
     * Sanitize float
     * 
     * @param mixed $value Value to sanitize
     * @return float Sanitized float
     */
    function sanitize_float($value): float
    {
        return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
}

if (!function_exists('validate_all')) {
    /**
     * Validate multiple values against multiple rules
     * 
     * @param array $data Data to validate
     * @param array $rules Validation rules
     * @return array Validation results
     */
    function validate_all(array $data, array $rules): array
    {
        $results = [];
        
        foreach ($rules as $field => $rule) {
            $value = $data[$field] ?? null;
            $results[$field] = $rule($value);
        }
        
        return $results;
    }
}
