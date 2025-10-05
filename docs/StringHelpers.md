### StringHelpers

Clean, transform, and analyze strings: slugify, case transforms, extraction, masking, similarity, limits, and random generators.

#### Function Index

- str_random_alpha(int $length = 10): string
- str_random_alnum(int $length = 10): string
- str_random_symbols(int $length = 10): string
- str_slugify(string $string, string $separator = '-'): string
- str_starts_with_any(string $string, array $needles): bool
- str_ends_with_any(string $string, array $needles): bool
- str_between(string $string, string $start, string $end): ?string
- str_limit_middle(string $string, int $limit, string $end = '...'): string
- str_remove_spaces(string $string): string
- str_remove_special(string $string, string $allowed = 'a-zA-Z0-9\s'): string
- str_to_camel_case(string $string): string
- str_to_snake_case(string $string): string
- str_to_kebab_case(string $string): string
- str_to_pascal_case(string $string): string
- str_repeat_each(string $string, int $times): string
- str_is_palindrome(string $string): bool
- str_word_count_unicode(string $string): int
- str_title_case(string $string): string
- str_sentence_case(string $string): string
- str_reverse_words(string $string): string
- str_mask_middle(string $string, int $visible = 2, string $mask = '*'): string
- str_extract_emails(string $string): array
- str_extract_urls(string $string): array
- str_extract_phone_numbers(string $string): array
- str_highlight(string $string, string|array $search, string $class = 'highlight'): string
- str_clean_html(string $string, string $allowed = ''): string
- str_truncate_words(string $string, int $words, string $suffix = '...'): string
- str_contains_all(string $string, array $substrings): bool
- str_contains_any(string $string, array $substrings): bool
- str_levenshtein_distance(string $a, string $b): int
- str_similarity_percentage(string $a, string $b): float
- str_remove_accents(string $string): string

#### Examples

```php
$slug = str_slugify('Laravel HelperBox Rocks!'); // 'laravel-helperbox-rocks'
$masked = str_mask_middle('4111111111111111', 4); // '4111********1111'
$emails = str_extract_emails('Contact: a@b.com, c@d.io');
```


