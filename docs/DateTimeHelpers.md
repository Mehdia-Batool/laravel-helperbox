### DateTimeHelpers

Friendly date comparisons, ranges, human formats, timezone utilities, arithmetic, and calendar helpers.

#### Function Index

- date_is_today(mixed $date): bool
- date_is_yesterday(mixed $date): bool
- date_is_tomorrow(mixed $date): bool
- date_diff_in_days(mixed $date1, mixed $date2): int
- date_diff_in_hours(mixed $date1, mixed $date2): int
- date_diff_in_minutes(mixed $date1, mixed $date2): int
- date_start_of_week(mixed $date, int $startDay = 1): DateTime
- date_end_of_week(mixed $date, int $startDay = 1): DateTime
- date_start_of_month(mixed $date): DateTime
- date_end_of_month(mixed $date): DateTime
- date_start_of_year(mixed $date): DateTime
- date_end_of_year(mixed $date): DateTime
- date_is_weekend(mixed $date): bool
- date_is_leap_year(int $year): bool
- date_days_in_month(int $month, int $year): int
- date_to_timezone(mixed $date, string $timezone): DateTime
- date_format_human(mixed $date): string
- date_ago(mixed $date): string
- date_from_timestamp(int $timestamp, string $timezone = 'UTC'): DateTime
- date_to_timestamp(mixed $date): int
- date_add_days(mixed $date, int $days): DateTime
- date_subtract_days(mixed $date, int $days): DateTime
- date_add_months(mixed $date, int $months): DateTime
- date_subtract_months(mixed $date, int $months): DateTime
- date_add_years(mixed $date, int $years): DateTime
- date_subtract_years(mixed $date, int $years): DateTime
- date_is_between(mixed $date, mixed $start, mixed $end, bool $inclusive = true): bool
- date_get_quarter(mixed $date): int
- date_get_week_of_year(mixed $date): int
- date_get_day_of_year(mixed $date): int
- date_get_age(mixed $birthDate, mixed $referenceDate = null): int
- date_get_working_days(mixed $startDate, mixed $endDate): int
- date_get_weekend_days(mixed $startDate, mixed $endDate): int
- date_format_relative(mixed $date): string
- date_get_timezone_list(): array
- date_convert_timezone(mixed $date, string $fromTimezone, string $toTimezone): DateTime

#### Examples

```php
if (date_is_weekend('2025-10-05')) { /* ... */ }
$ago = date_ago('-3 hours'); // "3 hours ago"
```


