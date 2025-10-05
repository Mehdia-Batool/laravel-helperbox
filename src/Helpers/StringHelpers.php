<?php

/**
 * String Helper Functions
 * 
 * This file contains 30+ advanced string manipulation functions
 * for text processing, validation, formatting, and transformation.
 * 
 * @package Subhashladumor\LaravelHelperbox
 * @author Subhash Ladumor
 */

if (!function_exists('str_random_alpha')) {
    /**
     * Generate random alphabetic string
     * 
     * @param int $length Length of the string
     * @return string Random alphabetic string
     */
    function str_random_alpha(int $length = 10): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $result = '';
        
        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[random_int(0, strlen($characters) - 1)];
        }
        
        return $result;
    }
}

if (!function_exists('str_random_alnum')) {
    /**
     * Generate random alphanumeric string
     * 
     * @param int $length Length of the string
     * @return string Random alphanumeric string
     */
    function str_random_alnum(int $length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $result = '';
        
        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[random_int(0, strlen($characters) - 1)];
        }
        
        return $result;
    }
}

if (!function_exists('str_random_symbols')) {
    /**
     * Generate random symbols string
     * 
     * @param int $length Length of the string
     * @return string Random symbols string
     */
    function str_random_symbols(int $length = 10): string
    {
        $characters = '!@#$%^&*()_+-=[]{}|;:,.<>?';
        $result = '';
        
        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[random_int(0, strlen($characters) - 1)];
        }
        
        return $result;
    }
}

if (!function_exists('str_slugify')) {
    /**
     * Generate URL slug from string
     * 
     * @param string $string The string to slugify
     * @param string $separator Separator character
     * @return string URL slug
     */
    function str_slugify(string $string, string $separator = '-'): string
    {
        // Convert to lowercase
        $string = strtolower($string);
        
        // Replace spaces and special characters
        $string = preg_replace('/[^a-z0-9]+/', $separator, $string);
        
        // Remove leading/trailing separators
        $string = trim($string, $separator);
        
        return $string;
    }
}

if (!function_exists('str_starts_with_any')) {
    /**
     * Check if string starts with any of the given needles
     * 
     * @param string $string The string to check
     * @param array $needles Array of needles to check
     * @return bool True if starts with any needle
     */
    function str_starts_with_any(string $string, array $needles): bool
    {
        foreach ($needles as $needle) {
            if (str_starts_with($string, $needle)) {
                return true;
            }
        }
        
        return false;
    }
}

if (!function_exists('str_ends_with_any')) {
    /**
     * Check if string ends with any of the given needles
     * 
     * @param string $string The string to check
     * @param array $needles Array of needles to check
     * @return bool True if ends with any needle
     */
    function str_ends_with_any(string $string, array $needles): bool
    {
        foreach ($needles as $needle) {
            if (str_ends_with($string, $needle)) {
                return true;
            }
        }
        
        return false;
    }
}

if (!function_exists('str_between')) {
    /**
     * Get substring between two markers
     * 
     * @param string $string The string to search
     * @param string $start Start marker
     * @param string $end End marker
     * @return string|null Substring between markers or null
     */
    function str_between(string $string, string $start, string $end): ?string
    {
        $startPos = strpos($string, $start);
        if ($startPos === false) {
            return null;
        }
        
        $startPos += strlen($start);
        $endPos = strpos($string, $end, $startPos);
        if ($endPos === false) {
            return null;
        }
        
        return substr($string, $startPos, $endPos - $startPos);
    }
}

if (!function_exists('str_limit_middle')) {
    /**
     * Shorten string with middle ellipsis
     * 
     * @param string $string The string to shorten
     * @param int $limit Maximum length
     * @param string $end Ellipsis string
     * @return string Shortened string
     */
    function str_limit_middle(string $string, int $limit, string $end = '...'): string
    {
        if (strlen($string) <= $limit) {
            return $string;
        }
        
        $halfLimit = ($limit - strlen($end)) / 2;
        $start = substr($string, 0, floor($halfLimit));
        $endPart = substr($string, -ceil($halfLimit));
        
        return $start . $end . $endPart;
    }
}

if (!function_exists('str_remove_spaces')) {
    /**
     * Remove all spaces from string
     * 
     * @param string $string The string to process
     * @return string String without spaces
     */
    function str_remove_spaces(string $string): string
    {
        return str_replace(' ', '', $string);
    }
}

if (!function_exists('str_remove_special')) {
    /**
     * Remove special characters from string
     * 
     * @param string $string The string to process
     * @param string $allowed Allowed characters regex
     * @return string String without special characters
     */
    function str_remove_special(string $string, string $allowed = 'a-zA-Z0-9\s'): string
    {
        return preg_replace("/[^{$allowed}]/", '', $string);
    }
}

if (!function_exists('str_to_camel_case')) {
    /**
     * Convert string to camelCase
     * 
     * @param string $string The string to convert
     * @return string camelCase string
     */
    function str_to_camel_case(string $string): string
    {
        $string = preg_replace('/[^a-zA-Z0-9]+/', ' ', $string);
        $string = ucwords($string);
        $string = str_replace(' ', '', $string);
        
        return lcfirst($string);
    }
}

if (!function_exists('str_to_snake_case')) {
    /**
     * Convert string to snake_case
     * 
     * @param string $string The string to convert
     * @return string snake_case string
     */
    function str_to_snake_case(string $string): string
    {
        $string = preg_replace('/([a-z])([A-Z])/', '$1_$2', $string);
        $string = preg_replace('/[^a-zA-Z0-9]+/', '_', $string);
        $string = strtolower($string);
        
        return trim($string, '_');
    }
}

if (!function_exists('str_to_kebab_case')) {
    /**
     * Convert string to kebab-case
     * 
     * @param string $string The string to convert
     * @return string kebab-case string
     */
    function str_to_kebab_case(string $string): string
    {
        $string = preg_replace('/([a-z])([A-Z])/', '$1-$2', $string);
        $string = preg_replace('/[^a-zA-Z0-9]+/', '-', $string);
        $string = strtolower($string);
        
        return trim($string, '-');
    }
}

if (!function_exists('str_to_pascal_case')) {
    /**
     * Convert string to PascalCase
     * 
     * @param string $string The string to convert
     * @return string PascalCase string
     */
    function str_to_pascal_case(string $string): string
    {
        $string = preg_replace('/[^a-zA-Z0-9]+/', ' ', $string);
        $string = ucwords($string);
        $string = str_replace(' ', '', $string);
        
        return $string;
    }
}

if (!function_exists('str_repeat_each')) {
    /**
     * Repeat each character in string
     * 
     * @param string $string The string to process
     * @param int $times Number of times to repeat each character
     * @return string String with repeated characters
     */
    function str_repeat_each(string $string, int $times): string
    {
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $result .= str_repeat($string[$i], $times);
        }
        
        return $result;
    }
}

if (!function_exists('str_is_palindrome')) {
    /**
     * Check if string is palindrome
     * 
     * @param string $string The string to check
     * @return bool True if palindrome
     */
    function str_is_palindrome(string $string): bool
    {
        $string = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $string));
        return $string === strrev($string);
    }
}

if (!function_exists('str_word_count_unicode')) {
    /**
     * Count words with UTF-8 support
     * 
     * @param string $string The string to count
     * @return int Word count
     */
    function str_word_count_unicode(string $string): int
    {
        $words = preg_split('/\s+/u', trim($string));
        return count(array_filter($words, function($word) {
            return !empty(trim($word));
        }));
    }
}

if (!function_exists('str_title_case')) {
    /**
     * Convert string to title case
     * 
     * @param string $string The string to convert
     * @return string Title case string
     */
    function str_title_case(string $string): string
    {
        return ucwords(strtolower($string));
    }
}

if (!function_exists('str_sentence_case')) {
    /**
     * Convert string to sentence case
     * 
     * @param string $string The string to convert
     * @return string Sentence case string
     */
    function str_sentence_case(string $string): string
    {
        $sentences = preg_split('/([.!?]+)/', $string, -1, PREG_SPLIT_DELIM_CAPTURE);
        $result = '';
        
        for ($i = 0; $i < count($sentences); $i += 2) {
            if (isset($sentences[$i])) {
                $sentence = trim($sentences[$i]);
                if (!empty($sentence)) {
                    $result .= ucfirst(strtolower($sentence));
                }
            }
            if (isset($sentences[$i + 1])) {
                $result .= $sentences[$i + 1];
            }
        }
        
        return $result;
    }
}

if (!function_exists('str_reverse_words')) {
    /**
     * Reverse words in string
     * 
     * @param string $string The string to reverse
     * @return string String with reversed words
     */
    function str_reverse_words(string $string): string
    {
        $words = explode(' ', $string);
        return implode(' ', array_reverse($words));
    }
}

if (!function_exists('str_mask_middle')) {
    /**
     * Mask middle part of sensitive string
     * 
     * @param string $string The string to mask
     * @param int $visible Number of characters to keep visible at each end
     * @param string $mask Character to use for masking
     * @return string Masked string
     */
    function str_mask_middle(string $string, int $visible = 2, string $mask = '*'): string
    {
        $length = strlen($string);
        if ($length <= $visible * 2) {
            return str_repeat($mask, $length);
        }
        
        $start = substr($string, 0, $visible);
        $end = substr($string, -$visible);
        $middle = str_repeat($mask, $length - ($visible * 2));
        
        return $start . $middle . $end;
    }
}

if (!function_exists('str_extract_emails')) {
    /**
     * Extract email addresses from string
     * 
     * @param string $string The string to search
     * @return array Array of email addresses
     */
    function str_extract_emails(string $string): array
    {
        preg_match_all('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $string, $matches);
        return $matches[0] ?? [];
    }
}

if (!function_exists('str_extract_urls')) {
    /**
     * Extract URLs from string
     * 
     * @param string $string The string to search
     * @return array Array of URLs
     */
    function str_extract_urls(string $string): array
    {
        preg_match_all('/https?:\/\/[^\s<>"{}|\\^`\[\]]+/', $string, $matches);
        return $matches[0] ?? [];
    }
}

if (!function_exists('str_extract_phone_numbers')) {
    /**
     * Extract phone numbers from string
     * 
     * @param string $string The string to search
     * @return array Array of phone numbers
     */
    function str_extract_phone_numbers(string $string): array
    {
        preg_match_all('/[\+]?[1-9]?[0-9]{7,15}/', $string, $matches);
        return $matches[0] ?? [];
    }
}

if (!function_exists('str_highlight')) {
    /**
     * Highlight search terms in string
     * 
     * @param string $string The string to highlight
     * @param string|array $search Terms to highlight
     * @param string $class CSS class for highlighting
     * @return string String with highlighted terms
     */
    function str_highlight(string $string, $search, string $class = 'highlight'): string
    {
        if (is_string($search)) {
            $search = [$search];
        }
        
        foreach ($search as $term) {
            $string = preg_replace(
                '/(' . preg_quote($term, '/') . ')/i',
                '<span class="' . $class . '">$1</span>',
                $string
            );
        }
        
        return $string;
    }
}

if (!function_exists('str_clean_html')) {
    /**
     * Clean HTML tags from string
     * 
     * @param string $string The string to clean
     * @param string $allowed Allowed HTML tags
     * @return string Cleaned string
     */
    function str_clean_html(string $string, string $allowed = ''): string
    {
        if (empty($allowed)) {
            return strip_tags($string);
        }
        
        return strip_tags($string, $allowed);
    }
}

if (!function_exists('str_truncate_words')) {
    /**
     * Truncate string to specified number of words
     * 
     * @param string $string The string to truncate
     * @param int $words Number of words to keep
     * @param string $suffix Suffix to append
     * @return string Truncated string
     */
    function str_truncate_words(string $string, int $words, string $suffix = '...'): string
    {
        $wordArray = explode(' ', $string);
        
        if (count($wordArray) <= $words) {
            return $string;
        }
        
        return implode(' ', array_slice($wordArray, 0, $words)) . $suffix;
    }
}

if (!function_exists('str_contains_all')) {
    /**
     * Check if string contains all specified substrings
     * 
     * @param string $string The string to check
     * @param array $substrings Array of substrings to check
     * @return bool True if contains all substrings
     */
    function str_contains_all(string $string, array $substrings): bool
    {
        foreach ($substrings as $substring) {
            if (!str_contains($string, $substring)) {
                return false;
            }
        }
        
        return true;
    }
}

if (!function_exists('str_contains_any')) {
    /**
     * Check if string contains any of the specified substrings
     * 
     * @param string $string The string to check
     * @param array $substrings Array of substrings to check
     * @return bool True if contains any substring
     */
    function str_contains_any(string $string, array $substrings): bool
    {
        foreach ($substrings as $substring) {
            if (str_contains($string, $substring)) {
                return true;
            }
        }
        
        return false;
    }
}

if (!function_exists('str_levenshtein_distance')) {
    /**
     * Calculate Levenshtein distance between two strings
     * 
     * @param string $string1 First string
     * @param string $string2 Second string
     * @return int Levenshtein distance
     */
    function str_levenshtein_distance(string $string1, string $string2): int
    {
        return levenshtein($string1, $string2);
    }
}

if (!function_exists('str_similarity_percentage')) {
    /**
     * Calculate similarity percentage between two strings
     * 
     * @param string $string1 First string
     * @param string $string2 Second string
     * @return float Similarity percentage (0-100)
     */
    function str_similarity_percentage(string $string1, string $string2): float
    {
        $maxLength = max(strlen($string1), strlen($string2));
        if ($maxLength === 0) {
            return 100.0;
        }
        
        $distance = str_levenshtein_distance($string1, $string2);
        return (1 - ($distance / $maxLength)) * 100;
    }
}

if (!function_exists('str_remove_accents')) {
    /**
     * Remove accents from string
     * 
     * @param string $string The string to process
     * @return string String without accents
     */
    function str_remove_accents(string $string): string
    {
        $accents = [
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
            'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O',
            'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
            'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
            'Ç' => 'C', 'ç' => 'c',
            'Ñ' => 'N', 'ñ' => 'n'
        ];
        
        return strtr($string, $accents);
    }
}
