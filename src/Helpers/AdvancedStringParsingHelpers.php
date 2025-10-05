<?php

/**
 * Advanced String & Parsing Helper Functions
 * 
 * This file contains 40+ advanced string processing and parsing functions
 * for compression, pattern matching, text analysis, and data extraction.
 * 
 * @package Subhashladumor\LaravelHelperbox
 * @author Subhash Ladumor
 */

if (!function_exists('string_compress_rle')) {
    /**
     * Run-length encoding compression
     * 
     * @param string $string String to compress
     * @return string Compressed string
     */
    function string_compress_rle(string $string): string
    {
        if (empty($string)) {
            return '';
        }
        
        $compressed = '';
        $count = 1;
        $current = $string[0];
        
        for ($i = 1; $i < strlen($string); $i++) {
            if ($string[$i] === $current) {
                $count++;
            } else {
                $compressed .= $count . $current;
                $current = $string[$i];
                $count = 1;
            }
        }
        
        $compressed .= $count . $current;
        return $compressed;
    }
}

if (!function_exists('string_decompress_rle')) {
    /**
     * Decompress run-length encoded string
     * 
     * @param string $string Compressed string
     * @return string Decompressed string
     */
    function string_decompress_rle(string $string): string
    {
        if (empty($string)) {
            return '';
        }
        
        $decompressed = '';
        $i = 0;
        
        while ($i < strlen($string)) {
            $count = '';
            
            while ($i < strlen($string) && is_numeric($string[$i])) {
                $count .= $string[$i];
                $i++;
            }
            
            if ($i < strlen($string)) {
                $char = $string[$i];
                $decompressed .= str_repeat($char, (int)$count);
                $i++;
            }
        }
        
        return $decompressed;
    }
}

if (!function_exists('string_kmp_search')) {
    /**
     * Knuth-Morris-Pratt pattern search
     * 
     * @param string $string Text to search in
     * @param string $pattern Pattern to search for
     * @return array Array of positions where pattern is found
     */
    function string_kmp_search(string $string, string $pattern): array
    {
        if (empty($pattern)) {
            return [];
        }
        
        $positions = [];
        $stringLen = strlen($string);
        $patternLen = strlen($pattern);
        
        if ($patternLen > $stringLen) {
            return $positions;
        }
        
        $lps = computeLPSArray($pattern);
        $i = 0; // index for string
        $j = 0; // index for pattern
        
        while ($i < $stringLen) {
            if ($pattern[$j] === $string[$i]) {
                $i++;
                $j++;
            }
            
            if ($j === $patternLen) {
                $positions[] = $i - $j;
                $j = $lps[$j - 1];
            } elseif ($i < $stringLen && $pattern[$j] !== $string[$i]) {
                if ($j !== 0) {
                    $j = $lps[$j - 1];
                } else {
                    $i++;
                }
            }
        }
        
        return $positions;
    }
}

if (!function_exists('string_rabin_karp')) {
    /**
     * Rabin-Karp substring search
     * 
     * @param string $string Text to search in
     * @param string $pattern Pattern to search for
     * @return array Array of positions where pattern is found
     */
    function string_rabin_karp(string $string, string $pattern): array
    {
        if (empty($pattern)) {
            return [];
        }
        
        $positions = [];
        $stringLen = strlen($string);
        $patternLen = strlen($pattern);
        
        if ($patternLen > $stringLen) {
            return $positions;
        }
        
        $prime = 101;
        $patternHash = 0;
        $stringHash = 0;
        $h = 1;
        
        // Calculate hash value of pattern and first window of text
        for ($i = 0; $i < $patternLen; $i++) {
            $patternHash = ($patternHash * 256 + ord($pattern[$i])) % $prime;
            $stringHash = ($stringHash * 256 + ord($string[$i])) % $prime;
        }
        
        // Calculate h = pow(256, patternLen-1) % prime
        for ($i = 0; $i < $patternLen - 1; $i++) {
            $h = ($h * 256) % $prime;
        }
        
        // Slide the pattern over text
        for ($i = 0; $i <= $stringLen - $patternLen; $i++) {
            if ($patternHash === $stringHash) {
                // Check if characters match
                $j = 0;
                while ($j < $patternLen && $string[$i + $j] === $pattern[$j]) {
                    $j++;
                }
                
                if ($j === $patternLen) {
                    $positions[] = $i;
                }
            }
            
            // Calculate hash for next window
            if ($i < $stringLen - $patternLen) {
                $stringHash = (256 * ($stringHash - ord($string[$i]) * $h) + ord($string[$i + $patternLen])) % $prime;
                
                if ($stringHash < 0) {
                    $stringHash += $prime;
                }
            }
        }
        
        return $positions;
    }
}

if (!function_exists('string_levenshtein_distance')) {
    /**
     * Calculate Levenshtein distance between two strings
     * 
     * @param string $string1 First string
     * @param string $string2 Second string
     * @return int Levenshtein distance
     */
    function string_levenshtein_distance(string $string1, string $string2): int
    {
        $len1 = strlen($string1);
        $len2 = strlen($string2);
        
        if ($len1 === 0) return $len2;
        if ($len2 === 0) return $len1;
        
        $matrix = [];
        
        // Initialize first row and column
        for ($i = 0; $i <= $len1; $i++) {
            $matrix[$i][0] = $i;
        }
        for ($j = 0; $j <= $len2; $j++) {
            $matrix[0][$j] = $j;
        }
        
        // Fill the matrix
        for ($i = 1; $i <= $len1; $i++) {
            for ($j = 1; $j <= $len2; $j++) {
                $cost = ($string1[$i - 1] === $string2[$j - 1]) ? 0 : 1;
                
                $matrix[$i][$j] = min(
                    $matrix[$i - 1][$j] + 1,      // deletion
                    $matrix[$i][$j - 1] + 1,      // insertion
                    $matrix[$i - 1][$j - 1] + $cost // substitution
                );
            }
        }
        
        return $matrix[$len1][$len2];
    }
}

if (!function_exists('string_lcs')) {
    /**
     * Find longest common subsequence between two strings
     * 
     * @param string $string1 First string
     * @param string $string2 Second string
     * @return string Longest common subsequence
     */
    function string_lcs(string $string1, string $string2): string
    {
        $len1 = strlen($string1);
        $len2 = strlen($string2);
        
        if ($len1 === 0 || $len2 === 0) {
            return '';
        }
        
        $matrix = array_fill(0, $len1 + 1, array_fill(0, $len2 + 1, 0));
        
        // Build the matrix
        for ($i = 1; $i <= $len1; $i++) {
            for ($j = 1; $j <= $len2; $j++) {
                if ($string1[$i - 1] === $string2[$j - 1]) {
                    $matrix[$i][$j] = $matrix[$i - 1][$j - 1] + 1;
                } else {
                    $matrix[$i][$j] = max($matrix[$i - 1][$j], $matrix[$i][$j - 1]);
                }
            }
        }
        
        // Reconstruct the LCS
        $lcs = '';
        $i = $len1;
        $j = $len2;
        
        while ($i > 0 && $j > 0) {
            if ($string1[$i - 1] === $string2[$j - 1]) {
                $lcs = $string1[$i - 1] . $lcs;
                $i--;
                $j--;
            } elseif ($matrix[$i - 1][$j] > $matrix[$i][$j - 1]) {
                $i--;
            } else {
                $j--;
            }
        }
        
        return $lcs;
    }
}

if (!function_exists('string_longest_palindrome')) {
    /**
     * Find longest palindromic substring
     * 
     * @param string $string Input string
     * @return string Longest palindrome
     */
    function string_longest_palindrome(string $string): string
    {
        if (empty($string)) {
            return '';
        }
        
        $start = 0;
        $maxLen = 1;
        $len = strlen($string);
        
        for ($i = 0; $i < $len; $i++) {
            // Check for odd length palindromes
            $len1 = expandAroundCenter($string, $i, $i);
            if ($len1 > $maxLen) {
                $maxLen = $len1;
                $start = $i - intval(($len1 - 1) / 2);
            }
            
            // Check for even length palindromes
            $len2 = expandAroundCenter($string, $i, $i + 1);
            if ($len2 > $maxLen) {
                $maxLen = $len2;
                $start = $i - intval(($len2 - 1) / 2);
            }
        }
        
        return substr($string, $start, $maxLen);
    }
}

if (!function_exists('string_tokenize_quoted')) {
    /**
     * Tokenize string keeping quotes intact
     * 
     * @param string $string String to tokenize
     * @param string $delimiter Delimiter character
     * @return array Array of tokens
     */
    function string_tokenize_quoted(string $string, string $delimiter = ' '): array
    {
        $tokens = [];
        $current = '';
        $inQuotes = false;
        $quoteChar = '';
        
        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];
            
            if (($char === '"' || $char === "'") && !$inQuotes) {
                $inQuotes = true;
                $quoteChar = $char;
            } elseif ($char === $quoteChar && $inQuotes) {
                $inQuotes = false;
                $quoteChar = '';
            } elseif ($char === $delimiter && !$inQuotes) {
                if ($current !== '') {
                    $tokens[] = $current;
                    $current = '';
                }
            } else {
                $current .= $char;
            }
        }
        
        if ($current !== '') {
            $tokens[] = $current;
        }
        
        return $tokens;
    }
}

if (!function_exists('string_slugify_unique')) {
    /**
     * Generate unique slug from string
     * 
     * @param string $string String to slugify
     * @param callable $checker Function to check uniqueness
     * @param string $separator Separator character
     * @return string Unique slug
     */
    function string_slugify_unique(string $string, callable $checker, string $separator = '-'): string
    {
        $baseSlug = str_slugify($string, $separator);
        $slug = $baseSlug;
        $counter = 1;
        
        while ($checker($slug)) {
            $slug = $baseSlug . $separator . $counter;
            $counter++;
        }
        
        return $slug;
    }
}

if (!function_exists('string_html_strip_tags_safe')) {
    /**
     * Strip unsafe HTML tags but keep safe ones
     * 
     * @param string $html HTML string
     * @param array $allowedTags Allowed HTML tags
     * @return string Cleaned HTML
     */
    function string_html_strip_tags_safe(string $html, array $allowedTags = ['p', 'br', 'strong', 'em', 'a', 'ul', 'ol', 'li']): string
    {
        $allowedTagsString = '<' . implode('><', $allowedTags) . '>';
        return strip_tags($html, $allowedTagsString);
    }
}

if (!function_exists('string_extract_between')) {
    /**
     * Extract substring between two delimiters
     * 
     * @param string $string Input string
     * @param string $start Start delimiter
     * @param string $end End delimiter
     * @param bool $includeDelimiters Include delimiters in result
     * @return array Array of extracted strings
     */
    function string_extract_between(string $string, string $start, string $end, bool $includeDelimiters = false): array
    {
        $results = [];
        $startPos = 0;
        
        while (($startPos = strpos($string, $start, $startPos)) !== false) {
            $startPos += strlen($start);
            $endPos = strpos($string, $end, $startPos);
            
            if ($endPos !== false) {
                $extracted = substr($string, $startPos, $endPos - $startPos);
                
                if ($includeDelimiters) {
                    $extracted = $start . $extracted . $end;
                }
                
                $results[] = $extracted;
                $startPos = $endPos + strlen($end);
            } else {
                break;
            }
        }
        
        return $results;
    }
}

if (!function_exists('string_word_frequency')) {
    /**
     * Count frequency of each word in string
     * 
     * @param string $string Input string
     * @param bool $caseSensitive Case sensitive counting
     * @return array Word frequency array
     */
    function string_word_frequency(string $string, bool $caseSensitive = false): array
    {
        $words = preg_split('/\s+/', $caseSensitive ? $string : strtolower($string));
        $words = array_filter($words, function($word) {
            return !empty(trim($word));
        });
        
        return array_count_values($words);
    }
}

if (!function_exists('string_ngram')) {
    /**
     * Generate n-grams from text
     * 
     * @param string $text Input text
     * @param int $n N-gram size
     * @return array Array of n-grams
     */
    function string_ngram(string $text, int $n = 2): array
    {
        $words = preg_split('/\s+/', strtolower($text));
        $words = array_filter($words, function($word) {
            return !empty(trim($word));
        });
        
        $ngrams = [];
        $wordCount = count($words);
        
        for ($i = 0; $i <= $wordCount - $n; $i++) {
            $ngram = array_slice($words, $i, $n);
            $ngrams[] = implode(' ', $ngram);
        }
        
        return $ngrams;
    }
}

if (!function_exists('string_random_sentence')) {
    /**
     * Generate random sentence from word list
     * 
     * @param array $words Array of words
     * @param int $count Number of words in sentence
     * @return string Random sentence
     */
    function string_random_sentence(array $words, int $count = 5): string
    {
        if (empty($words) || $count <= 0) {
            return '';
        }
        
        $sentence = [];
        $wordCount = count($words);
        
        for ($i = 0; $i < $count; $i++) {
            $sentence[] = $words[array_rand($words)];
        }
        
        return implode(' ', $sentence);
    }
}

if (!function_exists('string_is_anagram')) {
    /**
     * Check if two strings are anagrams
     * 
     * @param string $string1 First string
     * @param string $string2 Second string
     * @return bool True if anagrams
     */
    function string_is_anagram(string $string1, string $string2): bool
    {
        $string1 = strtolower(preg_replace('/[^a-z]/', '', $string1));
        $string2 = strtolower(preg_replace('/[^a-z]/', '', $string2));
        
        if (strlen($string1) !== strlen($string2)) {
            return false;
        }
        
        $chars1 = str_split($string1);
        $chars2 = str_split($string2);
        
        sort($chars1);
        sort($chars2);
        
        return $chars1 === $chars2;
    }
}

if (!function_exists('string_case_switch')) {
    /**
     * Convert string to different cases
     * 
     * @param string $string Input string
     * @param string $mode Case mode (snake, camel, pascal, kebab)
     * @return string Converted string
     */
    function string_case_switch(string $string, string $mode): string
    {
        switch (strtolower($mode)) {
            case 'snake':
                return str_to_snake_case($string);
            case 'camel':
                return str_to_camel_case($string);
            case 'pascal':
                return str_to_pascal_case($string);
            case 'kebab':
                return str_to_kebab_case($string);
            default:
                return $string;
        }
    }
}

if (!function_exists('string_to_morse')) {
    /**
     * Convert text to Morse code
     * 
     * @param string $text Input text
     * @return string Morse code
     */
    function string_to_morse(string $text): string
    {
        $morseCode = [
            'A' => '.-', 'B' => '-...', 'C' => '-.-.', 'D' => '-..', 'E' => '.',
            'F' => '..-.', 'G' => '--.', 'H' => '....', 'I' => '..', 'J' => '.---',
            'K' => '-.-', 'L' => '.-..', 'M' => '--', 'N' => '-.', 'O' => '---',
            'P' => '.--.', 'Q' => '--.-', 'R' => '.-.', 'S' => '...', 'T' => '-',
            'U' => '..-', 'V' => '...-', 'W' => '.--', 'X' => '-..-', 'Y' => '-.--',
            'Z' => '--..', '0' => '-----', '1' => '.----', '2' => '..---', '3' => '...--',
            '4' => '....-', '5' => '.....', '6' => '-....', '7' => '--...', '8' => '---..',
            '9' => '----.'
        ];
        
        $morse = '';
        $text = strtoupper($text);
        
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            
            if ($char === ' ') {
                $morse .= ' / ';
            } elseif (isset($morseCode[$char])) {
                $morse .= $morseCode[$char] . ' ';
            }
        }
        
        return trim($morse);
    }
}

if (!function_exists('string_from_morse')) {
    /**
     * Convert Morse code back to text
     * 
     * @param string $morse Morse code
     * @return string Decoded text
     */
    function string_from_morse(string $morse): string
    {
        $morseCode = [
            '.-' => 'A', '-...' => 'B', '-.-.' => 'C', '-..' => 'D', '.' => 'E',
            '..-.' => 'F', '--.' => 'G', '....' => 'H', '..' => 'I', '.---' => 'J',
            '-.-' => 'K', '.-..' => 'L', '--' => 'M', '-.' => 'N', '---' => 'O',
            '.--.' => 'P', '--.-' => 'Q', '.-.' => 'R', '...' => 'S', '-' => 'T',
            '..-' => 'U', '...-' => 'V', '.--' => 'W', '-..-' => 'X', '-.--' => 'Y',
            '--..' => 'Z', '-----' => '0', '.----' => '1', '..---' => '2', '...--' => '3',
            '....-' => '4', '.....' => '5', '-....' => '6', '--...' => '7', '---..' => '8',
            '----.' => '9'
        ];
        
        $words = explode(' / ', $morse);
        $text = '';
        
        foreach ($words as $word) {
            $letters = explode(' ', trim($word));
            
            foreach ($letters as $letter) {
                if (isset($morseCode[$letter])) {
                    $text .= $morseCode[$letter];
                }
            }
            
            $text .= ' ';
        }
        
        return trim($text);
    }
}

if (!function_exists('string_to_slug_tree')) {
    /**
     * Convert array of categories into nested slug tree
     * 
     * @param array $categories Array of category strings
     * @param string $separator Separator character
     * @return array Nested tree structure
     */
    function string_to_slug_tree(array $categories, string $separator = '-'): array
    {
        $tree = [];
        
        foreach ($categories as $category) {
            $parts = explode($separator, str_slugify($category, $separator));
            $current = &$tree;
            
            foreach ($parts as $part) {
                if (!isset($current[$part])) {
                    $current[$part] = [];
                }
                $current = &$current[$part];
            }
        }
        
        return $tree;
    }
}

if (!function_exists('string_compress_huffman')) {
    /**
     * Compress string using Huffman coding
     * 
     * @param string $string String to compress
     * @return array Compressed data with tree
     */
    function string_compress_huffman(string $string): array
    {
        if (empty($string)) {
            return ['data' => '', 'tree' => []];
        }
        
        // Calculate character frequencies
        $frequencies = array_count_values(str_split($string));
        
        // Build Huffman tree
        $tree = buildHuffmanTree($frequencies);
        
        // Generate codes
        $codes = [];
        generateCodes($tree, '', $codes);
        
        // Encode string
        $encoded = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $encoded .= $codes[$string[$i]];
        }
        
        return [
            'data' => $encoded,
            'tree' => $tree,
            'original_length' => strlen($string)
        ];
    }
}

if (!function_exists('string_decompress_huffman')) {
    /**
     * Decompress Huffman encoded string
     * 
     * @param array $compressed Compressed data
     * @return string Decompressed string
     */
    function string_decompress_huffman(array $compressed): string
    {
        if (empty($compressed['data']) || empty($compressed['tree'])) {
            return '';
        }
        
        $decoded = '';
        $current = $compressed['tree'];
        $data = $compressed['data'];
        
        for ($i = 0; $i < strlen($data); $i++) {
            $bit = $data[$i];
            
            if ($bit === '0') {
                $current = $current['left'];
            } else {
                $current = $current['right'];
            }
            
            if (isset($current['char'])) {
                $decoded .= $current['char'];
                $current = $compressed['tree'];
            }
        }
        
        return $decoded;
    }
}

if (!function_exists('string_soundex_metaphone')) {
    /**
     * Generate both Soundex and Metaphone codes for string
     * 
     * @param string $string Input string
     * @return array Array with soundex and metaphone codes
     */
    function string_soundex_metaphone(string $string): array
    {
        return [
            'soundex' => soundex($string),
            'metaphone' => metaphone($string)
        ];
    }
}

if (!function_exists('string_phonetic_similarity')) {
    /**
     * Calculate phonetic similarity between two strings
     * 
     * @param string $string1 First string
     * @param string $string2 Second string
     * @return float Similarity score (0-1)
     */
    function string_phonetic_similarity(string $string1, string $string2): float
    {
        $soundex1 = soundex($string1);
        $soundex2 = soundex($string2);
        $metaphone1 = metaphone($string1);
        $metaphone2 = metaphone($string2);
        
        $soundexMatch = $soundex1 === $soundex2 ? 1 : 0;
        $metaphoneMatch = $metaphone1 === $metaphone2 ? 1 : 0;
        
        return ($soundexMatch + $metaphoneMatch) / 2;
    }
}

if (!function_exists('string_extract_numbers')) {
    /**
     * Extract all numbers from string
     * 
     * @param string $string Input string
     * @param bool $includeDecimals Include decimal numbers
     * @return array Array of numbers
     */
    function string_extract_numbers(string $string, bool $includeDecimals = true): array
    {
        $pattern = $includeDecimals ? '/\d+\.?\d*/' : '/\d+/';
        preg_match_all($pattern, $string, $matches);
        
        return array_map(function($num) {
            return is_numeric($num) ? (strpos($num, '.') !== false ? (float)$num : (int)$num) : $num;
        }, $matches[0]);
    }
}

if (!function_exists('string_extract_currency')) {
    /**
     * Extract currency amounts from string
     * 
     * @param string $string Input string
     * @return array Array of currency amounts
     */
    function string_extract_currency(string $string): array
    {
        preg_match_all('/\$[\d,]+\.?\d*/', $string, $matches);
        
        return array_map(function($amount) {
            return str_replace(['$', ','], '', $amount);
        }, $matches[0]);
    }
}

if (!function_exists('string_normalize_whitespace')) {
    /**
     * Normalize whitespace in string
     * 
     * @param string $string Input string
     * @param string $replacement Replacement character
     * @return string Normalized string
     */
    function string_normalize_whitespace(string $string, string $replacement = ' '): string
    {
        return preg_replace('/\s+/', $replacement, trim($string));
    }
}

if (!function_exists('string_remove_duplicates')) {
    /**
     * Remove duplicate characters from string
     * 
     * @param string $string Input string
     * @return string String with duplicates removed
     */
    function string_remove_duplicates(string $string): string
    {
        $seen = [];
        $result = '';
        
        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];
            if (!in_array($char, $seen)) {
                $seen[] = $char;
                $result .= $char;
            }
        }
        
        return $result;
    }
}

if (!function_exists('string_reverse_words')) {
    /**
     * Reverse order of words in string
     * 
     * @param string $string Input string
     * @return string String with reversed words
     */
    function string_reverse_words(string $string): string
    {
        $words = explode(' ', $string);
        return implode(' ', array_reverse($words));
    }
}

if (!function_exists('string_alternating_case')) {
    /**
     * Convert string to alternating case (StUdLy CaPs)
     * 
     * @param string $string Input string
     * @return string Alternating case string
     */
    function string_alternating_case(string $string): string
    {
        $result = '';
        $upper = true;
        
        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];
            
            if (ctype_alpha($char)) {
                $result .= $upper ? strtoupper($char) : strtolower($char);
                $upper = !$upper;
            } else {
                $result .= $char;
            }
        }
        
        return $result;
    }
}

if (!function_exists('string_remove_vowels')) {
    /**
     * Remove vowels from string
     * 
     * @param string $string Input string
     * @return string String without vowels
     */
    function string_remove_vowels(string $string): string
    {
        return preg_replace('/[aeiouAEIOU]/', '', $string);
    }
}

if (!function_exists('string_remove_consonants')) {
    /**
     * Remove consonants from string
     * 
     * @param string $string Input string
     * @return string String without consonants
     */
    function string_remove_consonants(string $string): string
    {
        return preg_replace('/[bcdfghjklmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ]/', '', $string);
    }
}

if (!function_exists('string_count_syllables')) {
    /**
     * Count syllables in word
     * 
     * @param string $word Input word
     * @return int Number of syllables
     */
    function string_count_syllables(string $word): int
    {
        $word = strtolower($word);
        $word = preg_replace('/[^a-z]/', '', $word);
        
        if (empty($word)) {
            return 0;
        }
        
        $vowels = 'aeiouy';
        $syllables = 0;
        $previousWasVowel = false;
        
        for ($i = 0; $i < strlen($word); $i++) {
            $isVowel = strpos($vowels, $word[$i]) !== false;
            
            if ($isVowel && !$previousWasVowel) {
                $syllables++;
            }
            
            $previousWasVowel = $isVowel;
        }
        
        // Handle silent 'e'
        if (substr($word, -1) === 'e' && $syllables > 1) {
            $syllables--;
        }
        
        return max(1, $syllables);
    }
}

if (!function_exists('string_reading_time')) {
    /**
     * Calculate estimated reading time for text
     * 
     * @param string $text Input text
     * @param int $wordsPerMinute Words per minute reading speed
     * @return array Reading time information
     */
    function string_reading_time(string $text, int $wordsPerMinute = 200): array
    {
        $wordCount = str_word_count($text);
        $minutes = $wordCount / $wordsPerMinute;
        $seconds = round($minutes * 60);
        
        return [
            'word_count' => $wordCount,
            'minutes' => round($minutes, 1),
            'seconds' => $seconds,
            'words_per_minute' => $wordsPerMinute
        ];
    }
}

// Helper functions for the algorithms above

if (!function_exists('computeLPSArray')) {
    function computeLPSArray(string $pattern): array
    {
        $len = strlen($pattern);
        $lps = array_fill(0, $len, 0);
        $length = 0;
        $i = 1;
        
        while ($i < $len) {
            if ($pattern[$i] === $pattern[$length]) {
                $length++;
                $lps[$i] = $length;
                $i++;
            } else {
                if ($length !== 0) {
                    $length = $lps[$length - 1];
                } else {
                    $lps[$i] = 0;
                    $i++;
                }
            }
        }
        
        return $lps;
    }
}

if (!function_exists('expandAroundCenter')) {
    function expandAroundCenter(string $string, int $left, int $right): int
    {
        $len = strlen($string);
        
        while ($left >= 0 && $right < $len && $string[$left] === $string[$right]) {
            $left--;
            $right++;
        }
        
        return $right - $left - 1;
    }
}

if (!function_exists('buildHuffmanTree')) {
    function buildHuffmanTree(array $frequencies): array
    {
        $heap = [];
        
        foreach ($frequencies as $char => $freq) {
            $heap[] = ['char' => $char, 'freq' => $freq, 'left' => null, 'right' => null];
        }
        
        while (count($heap) > 1) {
            usort($heap, function($a, $b) {
                return $a['freq'] - $b['freq'];
            });
            
            $left = array_shift($heap);
            $right = array_shift($heap);
            
            $merged = [
                'char' => null,
                'freq' => $left['freq'] + $right['freq'],
                'left' => $left,
                'right' => $right
            ];
            
            $heap[] = $merged;
        }
        
        return $heap[0];
    }
}

if (!function_exists('generateCodes')) {
    function generateCodes(array $node, string $code, array &$codes): void
    {
        if (isset($node['char'])) {
            $codes[$node['char']] = $code;
        } else {
            generateCodes($node['left'], $code . '0', $codes);
            generateCodes($node['right'], $code . '1', $codes);
        }
    }
}
