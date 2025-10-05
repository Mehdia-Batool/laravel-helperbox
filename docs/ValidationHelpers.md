### ValidationHelpers

Lightweight validators and sanitizers for common data types and formats.

#### Function Index

- validate_email(string $email): bool
- validate_url(string $url): bool
- validate_ip(string $ip): bool
- validate_ipv4(string $ip): bool
- validate_ipv6(string $ip): bool
- validate_json(string $json): bool
- validate_uuid(string $uuid): bool
- validate_base64(string $string): bool
- validate_phone(string $number, ?string $country = null): bool
- validate_credit_card(string $number): bool
- validate_password_strength(string $password, int $minLength = 8): bool
- validate_date_format(string $date, string $format = 'Y-m-d'): bool
- validate_time_format(string $time, string $format = 'H:i:s'): bool
- validate_alpha(string $string): bool
- validate_alnum(string $string): bool
- validate_digit(string $string): bool
- validate_hex(string $string): bool
- validate_ascii(string $string): bool
- validate_utf8(string $string): bool
- validate_length(string $string, int $min = 0, int $max = PHP_INT_MAX): bool
- validate_range(mixed $value, int|float $min, int|float $max): bool
- validate_in_array(mixed $value, array $array): bool
- validate_not_in_array(mixed $value, array $array): bool
- validate_regex(string $string, string $pattern): bool
- validate_file_extension(string $filename, array $allowedExtensions): bool
- validate_file_size(string $filePath, int $maxSize): bool
- validate_image_dimensions(string $filePath, int $maxWidth, int $maxHeight): bool
- sanitize_string(string $string, string $allowed = 'a-zA-Z0-9\\s'): string
- sanitize_html(string $html, string $allowedTags = ''): string
- sanitize_email(string $email): string
- sanitize_url(string $url): string
- sanitize_int(mixed $value): int
- sanitize_float(mixed $value): float
- validate_all(array $data, array $rules): array

#### Examples

```php
if (!validate_email($email)) { /* handle */ }
$clean = sanitize_string($input);
```


