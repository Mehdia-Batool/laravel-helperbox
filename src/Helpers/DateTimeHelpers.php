<?php

/**
 * Date & Time Helper Functions
 * 
 * This file contains 30+ advanced date and time utility functions
 * for date calculations, formatting, timezone handling, and time operations.
 * 
 * @package Subhashladumor\LaravelHelperbox
 * @author Subhash Ladumor
 */

if (!function_exists('date_is_today')) {
    /**
     * Check if date is today
     * 
     * @param mixed $date Date to check
     * @return bool True if today
     */
    function date_is_today($date): bool
    {
        if (!$date) {
            return false;
        }
        
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $today = new DateTime();
        
        return $date->format('Y-m-d') === $today->format('Y-m-d');
    }
}

if (!function_exists('date_is_yesterday')) {
    /**
     * Check if date is yesterday
     * 
     * @param mixed $date Date to check
     * @return bool True if yesterday
     */
    function date_is_yesterday($date): bool
    {
        if (!$date) {
            return false;
        }
        
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $yesterday = new DateTime('-1 day');
        
        return $date->format('Y-m-d') === $yesterday->format('Y-m-d');
    }
}

if (!function_exists('date_is_tomorrow')) {
    /**
     * Check if date is tomorrow
     * 
     * @param mixed $date Date to check
     * @return bool True if tomorrow
     */
    function date_is_tomorrow($date): bool
    {
        if (!$date) {
            return false;
        }
        
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $tomorrow = new DateTime('+1 day');
        
        return $date->format('Y-m-d') === $tomorrow->format('Y-m-d');
    }
}

if (!function_exists('date_diff_in_days')) {
    /**
     * Calculate days difference between two dates
     * 
     * @param mixed $date1 First date
     * @param mixed $date2 Second date
     * @return int Days difference
     */
    function date_diff_in_days($date1, $date2): int
    {
        $date1 = $date1 instanceof DateTime ? $date1 : new DateTime($date1);
        $date2 = $date2 instanceof DateTime ? $date2 : new DateTime($date2);
        
        $diff = $date1->diff($date2);
        return $diff->days;
    }
}

if (!function_exists('date_diff_in_hours')) {
    /**
     * Calculate hours difference between two dates
     * 
     * @param mixed $date1 First date
     * @param mixed $date2 Second date
     * @return int Hours difference
     */
    function date_diff_in_hours($date1, $date2): int
    {
        $date1 = $date1 instanceof DateTime ? $date1 : new DateTime($date1);
        $date2 = $date2 instanceof DateTime ? $date2 : new DateTime($date2);
        
        $diff = $date1->diff($date2);
        return ($diff->days * 24) + $diff->h;
    }
}

if (!function_exists('date_diff_in_minutes')) {
    /**
     * Calculate minutes difference between two dates
     * 
     * @param mixed $date1 First date
     * @param mixed $date2 Second date
     * @return int Minutes difference
     */
    function date_diff_in_minutes($date1, $date2): int
    {
        $date1 = $date1 instanceof DateTime ? $date1 : new DateTime($date1);
        $date2 = $date2 instanceof DateTime ? $date2 : new DateTime($date2);
        
        $diff = $date1->diff($date2);
        return (($diff->days * 24) + $diff->h) * 60 + $diff->i;
    }
}

if (!function_exists('date_start_of_week')) {
    /**
     * Get start of week for given date
     * 
     * @param mixed $date Date
     * @param int $startDay Start day of week (0 = Sunday, 1 = Monday)
     * @return DateTime Start of week
     */
    function date_start_of_week($date, int $startDay = 1): DateTime
    {
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $dayOfWeek = $date->format('w');
        
        $daysToSubtract = ($dayOfWeek - $startDay + 7) % 7;
        
        $startOfWeek = clone $date;
        $startOfWeek->modify("-{$daysToSubtract} days");
        $startOfWeek->setTime(0, 0, 0);
        
        return $startOfWeek;
    }
}

if (!function_exists('date_end_of_week')) {
    /**
     * Get end of week for given date
     * 
     * @param mixed $date Date
     * @param int $startDay Start day of week (0 = Sunday, 1 = Monday)
     * @return DateTime End of week
     */
    function date_end_of_week($date, int $startDay = 1): DateTime
    {
        $startOfWeek = date_start_of_week($date, $startDay);
        $endOfWeek = clone $startOfWeek;
        $endOfWeek->modify('+6 days');
        $endOfWeek->setTime(23, 59, 59);
        
        return $endOfWeek;
    }
}

if (!function_exists('date_start_of_month')) {
    /**
     * Get start of month for given date
     * 
     * @param mixed $date Date
     * @return DateTime Start of month
     */
    function date_start_of_month($date): DateTime
    {
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $startOfMonth = clone $date;
        $startOfMonth->modify('first day of this month');
        $startOfMonth->setTime(0, 0, 0);
        
        return $startOfMonth;
    }
}

if (!function_exists('date_end_of_month')) {
    /**
     * Get end of month for given date
     * 
     * @param mixed $date Date
     * @return DateTime End of month
     */
    function date_end_of_month($date): DateTime
    {
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $endOfMonth = clone $date;
        $endOfMonth->modify('last day of this month');
        $endOfMonth->setTime(23, 59, 59);
        
        return $endOfMonth;
    }
}

if (!function_exists('date_start_of_year')) {
    /**
     * Get start of year for given date
     * 
     * @param mixed $date Date
     * @return DateTime Start of year
     */
    function date_start_of_year($date): DateTime
    {
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $startOfYear = clone $date;
        $startOfYear->modify('first day of January this year');
        $startOfYear->setTime(0, 0, 0);
        
        return $startOfYear;
    }
}

if (!function_exists('date_end_of_year')) {
    /**
     * Get end of year for given date
     * 
     * @param mixed $date Date
     * @return DateTime End of year
     */
    function date_end_of_year($date): DateTime
    {
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $endOfYear = clone $date;
        $endOfYear->modify('last day of December this year');
        $endOfYear->setTime(23, 59, 59);
        
        return $endOfYear;
    }
}

if (!function_exists('date_is_weekend')) {
    /**
     * Check if date is weekend
     * 
     * @param mixed $date Date to check
     * @return bool True if weekend
     */
    function date_is_weekend($date): bool
    {
        if (!$date) {
            return false;
        }
        
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $dayOfWeek = $date->format('w');
        
        return $dayOfWeek == 0 || $dayOfWeek == 6; // Sunday or Saturday
    }
}

if (!function_exists('date_is_leap_year')) {
    /**
     * Check if year is leap year
     * 
     * @param int $year Year to check
     * @return bool True if leap year
     */
    function date_is_leap_year(int $year): bool
    {
        return ($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0);
    }
}

if (!function_exists('date_days_in_month')) {
    /**
     * Get number of days in month
     * 
     * @param int $month Month (1-12)
     * @param int $year Year
     * @return int Number of days
     */
    function date_days_in_month(int $month, int $year): int
    {
        return cal_days_in_month(CAL_GREGORIAN, $month, $year);
    }
}

if (!function_exists('date_to_timezone')) {
    /**
     * Convert date to different timezone
     * 
     * @param mixed $date Date to convert
     * @param string $timezone Target timezone
     * @return DateTime Converted date
     */
    function date_to_timezone($date, string $timezone): DateTime
    {
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $converted = clone $date;
        $converted->setTimezone(new DateTimeZone($timezone));
        
        return $converted;
    }
}

if (!function_exists('date_format_human')) {
    /**
     * Format date in human-readable format
     * 
     * @param mixed $date Date to format
     * @return string Human-readable date
     */
    function date_format_human($date): string
    {
        if (!$date) {
            return '';
        }
        
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $now = new DateTime();
        $diff = $date->diff($now);
        
        if ($diff->days > 7) {
            return $date->format('M j, Y');
        } elseif ($diff->days > 0) {
            return $date->format('M j');
        } elseif ($diff->h > 0) {
            return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
        } elseif ($diff->i > 0) {
            return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
        } else {
            return 'Just now';
        }
    }
}

if (!function_exists('date_ago')) {
    /**
     * Get "time ago" format for date
     * 
     * @param mixed $date Date
     * @return string Time ago string
     */
    function date_ago($date): string
    {
        if (!$date) {
            return '';
        }
        
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $now = new DateTime();
        $diff = $date->diff($now);
        
        if ($diff->y > 0) {
            return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
        } elseif ($diff->m > 0) {
            return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
        } elseif ($diff->d > 0) {
            return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
        } elseif ($diff->h > 0) {
            return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
        } elseif ($diff->i > 0) {
            return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
        } else {
            return 'Just now';
        }
    }
}

if (!function_exists('date_from_timestamp')) {
    /**
     * Create date from timestamp
     * 
     * @param int $timestamp Unix timestamp
     * @param string $timezone Timezone
     * @return DateTime Date object
     */
    function date_from_timestamp(int $timestamp, string $timezone = 'UTC'): DateTime
    {
        $date = new DateTime();
        $date->setTimestamp($timestamp);
        $date->setTimezone(new DateTimeZone($timezone));
        
        return $date;
    }
}

if (!function_exists('date_to_timestamp')) {
    /**
     * Convert date to timestamp
     * 
     * @param mixed $date Date to convert
     * @return int Unix timestamp
     */
    function date_to_timestamp($date): int
    {
        if (!$date) {
            return 0;
        }
        
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        return $date->getTimestamp();
    }
}

if (!function_exists('date_add_days')) {
    /**
     * Add days to date
     * 
     * @param mixed $date Date
     * @param int $days Number of days to add
     * @return DateTime New date
     */
    function date_add_days($date, int $days): DateTime
    {
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $newDate = clone $date;
        $newDate->modify("+{$days} days");
        
        return $newDate;
    }
}

if (!function_exists('date_subtract_days')) {
    /**
     * Subtract days from date
     * 
     * @param mixed $date Date
     * @param int $days Number of days to subtract
     * @return DateTime New date
     */
    function date_subtract_days($date, int $days): DateTime
    {
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $newDate = clone $date;
        $newDate->modify("-{$days} days");
        
        return $newDate;
    }
}

if (!function_exists('date_add_months')) {
    /**
     * Add months to date
     * 
     * @param mixed $date Date
     * @param int $months Number of months to add
     * @return DateTime New date
     */
    function date_add_months($date, int $months): DateTime
    {
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $newDate = clone $date;
        $newDate->modify("+{$months} months");
        
        return $newDate;
    }
}

if (!function_exists('date_subtract_months')) {
    /**
     * Subtract months from date
     * 
     * @param mixed $date Date
     * @param int $months Number of months to subtract
     * @return DateTime New date
     */
    function date_subtract_months($date, int $months): DateTime
    {
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $newDate = clone $date;
        $newDate->modify("-{$months} months");
        
        return $newDate;
    }
}

if (!function_exists('date_add_years')) {
    /**
     * Add years to date
     * 
     * @param mixed $date Date
     * @param int $years Number of years to add
     * @return DateTime New date
     */
    function date_add_years($date, int $years): DateTime
    {
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $newDate = clone $date;
        $newDate->modify("+{$years} years");
        
        return $newDate;
    }
}

if (!function_exists('date_subtract_years')) {
    /**
     * Subtract years from date
     * 
     * @param mixed $date Date
     * @param int $years Number of years to subtract
     * @return DateTime New date
     */
    function date_subtract_years($date, int $years): DateTime
    {
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $newDate = clone $date;
        $newDate->modify("-{$years} years");
        
        return $newDate;
    }
}

if (!function_exists('date_is_between')) {
    /**
     * Check if date is between two dates
     * 
     * @param mixed $date Date to check
     * @param mixed $start Start date
     * @param mixed $end End date
     * @param bool $inclusive Include boundaries
     * @return bool True if between
     */
    function date_is_between($date, $start, $end, bool $inclusive = true): bool
    {
        if (!$date || !$start || !$end) {
            return false;
        }
        
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $start = $start instanceof DateTime ? $start : new DateTime($start);
        $end = $end instanceof DateTime ? $end : new DateTime($end);
        
        if ($inclusive) {
            return $date >= $start && $date <= $end;
        } else {
            return $date > $start && $date < $end;
        }
    }
}

if (!function_exists('date_get_quarter')) {
    /**
     * Get quarter of year for date
     * 
     * @param mixed $date Date
     * @return int Quarter (1-4)
     */
    function date_get_quarter($date): int
    {
        if (!$date) {
            return 0;
        }
        
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $month = (int) $date->format('n');
        
        return ceil($month / 3);
    }
}

if (!function_exists('date_get_week_of_year')) {
    /**
     * Get week number of year
     * 
     * @param mixed $date Date
     * @return int Week number
     */
    function date_get_week_of_year($date): int
    {
        if (!$date) {
            return 0;
        }
        
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        return (int) $date->format('W');
    }
}

if (!function_exists('date_get_day_of_year')) {
    /**
     * Get day number of year
     * 
     * @param mixed $date Date
     * @return int Day number
     */
    function date_get_day_of_year($date): int
    {
        if (!$date) {
            return 0;
        }
        
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        return (int) $date->format('z') + 1;
    }
}

if (!function_exists('date_get_age')) {
    /**
     * Calculate age from birth date
     * 
     * @param mixed $birthDate Birth date
     * @param mixed $referenceDate Reference date (default: now)
     * @return int Age in years
     */
    function date_get_age($birthDate, $referenceDate = null): int
    {
        if (!$birthDate) {
            return 0;
        }
        
        $birthDate = $birthDate instanceof DateTime ? $birthDate : new DateTime($birthDate);
        $referenceDate = $referenceDate ? ($referenceDate instanceof DateTime ? $referenceDate : new DateTime($referenceDate)) : new DateTime();
        
        $age = $birthDate->diff($referenceDate);
        return $age->y;
    }
}

if (!function_exists('date_get_working_days')) {
    /**
     * Get number of working days between two dates
     * 
     * @param mixed $startDate Start date
     * @param mixed $endDate End date
     * @return int Number of working days
     */
    function date_get_working_days($startDate, $endDate): int
    {
        if (!$startDate || !$endDate) {
            return 0;
        }
        
        $startDate = $startDate instanceof DateTime ? $startDate : new DateTime($startDate);
        $endDate = $endDate instanceof DateTime ? $endDate : new DateTime($endDate);
        
        $workingDays = 0;
        $current = clone $startDate;
        
        while ($current <= $endDate) {
            if (!date_is_weekend($current)) {
                $workingDays++;
            }
            $current->modify('+1 day');
        }
        
        return $workingDays;
    }
}

if (!function_exists('date_get_weekend_days')) {
    /**
     * Get number of weekend days between two dates
     * 
     * @param mixed $startDate Start date
     * @param mixed $endDate End date
     * @return int Number of weekend days
     */
    function date_get_weekend_days($startDate, $endDate): int
    {
        if (!$startDate || !$endDate) {
            return 0;
        }
        
        $startDate = $startDate instanceof DateTime ? $startDate : new DateTime($startDate);
        $endDate = $endDate instanceof DateTime ? $endDate : new DateTime($endDate);
        
        $weekendDays = 0;
        $current = clone $startDate;
        
        while ($current <= $endDate) {
            if (date_is_weekend($current)) {
                $weekendDays++;
            }
            $current->modify('+1 day');
        }
        
        return $weekendDays;
    }
}

if (!function_exists('date_format_relative')) {
    /**
     * Format date in relative format (e.g., "2 hours ago", "in 3 days")
     * 
     * @param mixed $date Date
     * @return string Relative format
     */
    function date_format_relative($date): string
    {
        if (!$date) {
            return '';
        }
        
        $date = $date instanceof DateTime ? $date : new DateTime($date);
        $now = new DateTime();
        $diff = $date->diff($now);
        
        if ($date < $now) {
            // Past
            if ($diff->y > 0) {
                return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
            } elseif ($diff->m > 0) {
                return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
            } elseif ($diff->d > 0) {
                return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
            } elseif ($diff->h > 0) {
                return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
            } elseif ($diff->i > 0) {
                return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
            } else {
                return 'Just now';
            }
        } else {
            // Future
            if ($diff->y > 0) {
                return 'in ' . $diff->y . ' year' . ($diff->y > 1 ? 's' : '');
            } elseif ($diff->m > 0) {
                return 'in ' . $diff->m . ' month' . ($diff->m > 1 ? 's' : '');
            } elseif ($diff->d > 0) {
                return 'in ' . $diff->d . ' day' . ($diff->d > 1 ? 's' : '');
            } elseif ($diff->h > 0) {
                return 'in ' . $diff->h . ' hour' . ($diff->h > 1 ? 's' : '');
            } elseif ($diff->i > 0) {
                return 'in ' . $diff->i . ' minute' . ($diff->i > 1 ? 's' : '');
            } else {
                return 'Now';
            }
        }
    }
}

if (!function_exists('date_get_timezone_list')) {
    /**
     * Get list of available timezones
     * 
     * @return array Array of timezones
     */
    function date_get_timezone_list(): array
    {
        return DateTimeZone::listIdentifiers();
    }
}

if (!function_exists('date_convert_timezone')) {
    /**
     * Convert date from one timezone to another
     * 
     * @param mixed $date Date to convert
     * @param string $fromTimezone Source timezone
     * @param string $toTimezone Target timezone
     * @return DateTime Converted date
     */
    function date_convert_timezone($date, string $fromTimezone, string $toTimezone): DateTime
    {
        $date = $date instanceof DateTime ? $date : new DateTime($date, new DateTimeZone($fromTimezone));
        $date->setTimezone(new DateTimeZone($toTimezone));
        
        return $date;
    }
}
