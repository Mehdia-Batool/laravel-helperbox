<?php

/**
 * Math Helper Functions
 * 
 * This file contains 30+ advanced mathematical functions
 * for calculations, algorithms, statistics, and numerical operations.
 * 
 * @package Subhashladumor\LaravelHelperbox
 * @author Subhash Ladumor
 */

if (!function_exists('math_factorial')) {
    /**
     * Calculate factorial of a number
     * 
     * @param int $n The number to calculate factorial for
     * @return int|float Factorial result
     */
    function math_factorial(int $n)
    {
        if ($n < 0) {
            throw new InvalidArgumentException('Factorial is not defined for negative numbers');
        }
        
        if ($n === 0 || $n === 1) {
            return 1;
        }
        
        $result = 1;
        for ($i = 2; $i <= $n; $i++) {
            $result *= $i;
        }
        
        return $result;
    }
}

if (!function_exists('math_fibonacci')) {
    /**
     * Get nth Fibonacci number
     * 
     * @param int $n Position in Fibonacci sequence
     * @return int Fibonacci number
     */
    function math_fibonacci(int $n): int
    {
        if ($n < 0) {
            throw new InvalidArgumentException('Fibonacci is not defined for negative numbers');
        }
        
        if ($n <= 1) {
            return $n;
        }
        
        $a = 0;
        $b = 1;
        
        for ($i = 2; $i <= $n; $i++) {
            $temp = $a + $b;
            $a = $b;
            $b = $temp;
        }
        
        return $b;
    }
}

if (!function_exists('math_is_prime')) {
    /**
     * Check if number is prime
     * 
     * @param int $n The number to check
     * @return bool True if prime
     */
    function math_is_prime(int $n): bool
    {
        if ($n < 2) {
            return false;
        }
        
        if ($n === 2) {
            return true;
        }
        
        if ($n % 2 === 0) {
            return false;
        }
        
        for ($i = 3; $i <= sqrt($n); $i += 2) {
            if ($n % $i === 0) {
                return false;
            }
        }
        
        return true;
    }
}

if (!function_exists('math_gcd')) {
    /**
     * Calculate greatest common divisor
     * 
     * @param int $a First number
     * @param int $b Second number
     * @return int GCD
     */
    function math_gcd(int $a, int $b): int
    {
        $a = abs($a);
        $b = abs($b);
        
        while ($b !== 0) {
            $temp = $b;
            $b = $a % $b;
            $a = $temp;
        }
        
        return $a;
    }
}

if (!function_exists('math_lcm')) {
    /**
     * Calculate least common multiple
     * 
     * @param int $a First number
     * @param int $b Second number
     * @return int LCM
     */
    function math_lcm(int $a, int $b): int
    {
        return abs($a * $b) / math_gcd($a, $b);
    }
}

if (!function_exists('math_percentage')) {
    /**
     * Calculate percentage
     * 
     * @param float $part The part value
     * @param float $total The total value
     * @param int $decimals Number of decimal places
     * @return float Percentage
     */
    function math_percentage(float $part, float $total, int $decimals = 2): float
    {
        if ($total === 0) {
            return 0;
        }
        
        return round(($part / $total) * 100, $decimals);
    }
}

if (!function_exists('math_average')) {
    /**
     * Calculate average of numbers
     * 
     * @param array $numbers Array of numbers
     * @return float Average
     */
    function math_average(array $numbers): float
    {
        if (empty($numbers)) {
            return 0;
        }
        
        return array_sum($numbers) / count($numbers);
    }
}

if (!function_exists('math_median')) {
    /**
     * Calculate median of numbers
     * 
     * @param array $numbers Array of numbers
     * @return float Median
     */
    function math_median(array $numbers): float
    {
        if (empty($numbers)) {
            return 0;
        }
        
        sort($numbers);
        $count = count($numbers);
        $middle = floor($count / 2);
        
        if ($count % 2 === 0) {
            return ($numbers[$middle - 1] + $numbers[$middle]) / 2;
        }
        
        return $numbers[$middle];
    }
}

if (!function_exists('math_mode')) {
    /**
     * Calculate mode of numbers
     * 
     * @param array $numbers Array of numbers
     * @return array Array of modes
     */
    function math_mode(array $numbers): array
    {
        if (empty($numbers)) {
            return [];
        }
        
        $frequency = array_count_values($numbers);
        $maxFrequency = max($frequency);
        
        return array_keys($frequency, $maxFrequency);
    }
}

if (!function_exists('math_standard_deviation')) {
    /**
     * Calculate standard deviation
     * 
     * @param array $numbers Array of numbers
     * @param bool $sample Whether to calculate sample standard deviation
     * @return float Standard deviation
     */
    function math_standard_deviation(array $numbers, bool $sample = false): float
    {
        if (empty($numbers)) {
            return 0;
        }
        
        $mean = math_average($numbers);
        $variance = 0;
        
        foreach ($numbers as $number) {
            $variance += pow($number - $mean, 2);
        }
        
        $divisor = $sample ? count($numbers) - 1 : count($numbers);
        
        return sqrt($variance / $divisor);
    }
}

if (!function_exists('math_variance')) {
    /**
     * Calculate variance
     * 
     * @param array $numbers Array of numbers
     * @param bool $sample Whether to calculate sample variance
     * @return float Variance
     */
    function math_variance(array $numbers, bool $sample = false): float
    {
        if (empty($numbers)) {
            return 0;
        }
        
        $mean = math_average($numbers);
        $variance = 0;
        
        foreach ($numbers as $number) {
            $variance += pow($number - $mean, 2);
        }
        
        $divisor = $sample ? count($numbers) - 1 : count($numbers);
        
        return $variance / $divisor;
    }
}

if (!function_exists('math_round_up')) {
    /**
     * Round number up to specified precision
     * 
     * @param float $number The number to round
     * @param int $precision Number of decimal places
     * @return float Rounded up number
     */
    function math_round_up(float $number, int $precision = 0): float
    {
        $multiplier = pow(10, $precision);
        return ceil($number * $multiplier) / $multiplier;
    }
}

if (!function_exists('math_round_down')) {
    /**
     * Round number down to specified precision
     * 
     * @param float $number The number to round
     * @param int $precision Number of decimal places
     * @return float Rounded down number
     */
    function math_round_down(float $number, int $precision = 0): float
    {
        $multiplier = pow(10, $precision);
        return floor($number * $multiplier) / $multiplier;
    }
}

if (!function_exists('math_factorize')) {
    /**
     * Prime factorization of a number
     * 
     * @param int $n The number to factorize
     * @return array Array of prime factors
     */
    function math_factorize(int $n): array
    {
        if ($n < 2) {
            return [];
        }
        
        $factors = [];
        $divisor = 2;
        
        while ($divisor * $divisor <= $n) {
            while ($n % $divisor === 0) {
                $factors[] = $divisor;
                $n /= $divisor;
            }
            $divisor++;
        }
        
        if ($n > 1) {
            $factors[] = $n;
        }
        
        return $factors;
    }
}

if (!function_exists('math_log_base')) {
    /**
     * Calculate logarithm with custom base
     * 
     * @param float $number The number
     * @param float $base The base
     * @return float Logarithm result
     */
    function math_log_base(float $number, float $base): float
    {
        if ($base <= 0 || $base === 1) {
            throw new InvalidArgumentException('Base must be positive and not equal to 1');
        }
        
        if ($number <= 0) {
            throw new InvalidArgumentException('Number must be positive');
        }
        
        return log($number) / log($base);
    }
}

if (!function_exists('math_root')) {
    /**
     * Calculate nth root of a number
     * 
     * @param float $number The number
     * @param int $degree The degree of root
     * @return float Root result
     */
    function math_root(float $number, int $degree): float
    {
        if ($degree === 0) {
            throw new InvalidArgumentException('Cannot calculate 0th root');
        }
        
        if ($degree % 2 === 0 && $number < 0) {
            throw new InvalidArgumentException('Cannot calculate even root of negative number');
        }
        
        return pow($number, 1 / $degree);
    }
}

if (!function_exists('math_random_range')) {
    /**
     * Generate random number in range
     * 
     * @param float $min Minimum value
     * @param float $max Maximum value
     * @return float Random number
     */
    function math_random_range(float $min, float $max): float
    {
        return $min + (mt_rand() / mt_getrandmax()) * ($max - $min);
    }
}

if (!function_exists('math_convert_base')) {
    /**
     * Convert number between bases
     * 
     * @param string $number The number to convert
     * @param int $fromBase Source base
     * @param int $toBase Target base
     * @return string Converted number
     */
    function math_convert_base(string $number, int $fromBase, int $toBase): string
    {
        if ($fromBase < 2 || $fromBase > 36 || $toBase < 2 || $toBase > 36) {
            throw new InvalidArgumentException('Base must be between 2 and 36');
        }
        
        return base_convert($number, $fromBase, $toBase);
    }
}

if (!function_exists('math_percent_change')) {
    /**
     * Calculate percentage change between two values
     * 
     * @param float $oldValue Original value
     * @param float $newValue New value
     * @return float Percentage change
     */
    function math_percent_change(float $oldValue, float $newValue): float
    {
        if ($oldValue === 0) {
            return $newValue > 0 ? 100 : 0;
        }
        
        return (($newValue - $oldValue) / $oldValue) * 100;
    }
}

if (!function_exists('math_bmi')) {
    /**
     * Calculate Body Mass Index
     * 
     * @param float $weight Weight in kg
     * @param float $height Height in meters
     * @return float BMI value
     */
    function math_bmi(float $weight, float $height): float
    {
        if ($height <= 0) {
            throw new InvalidArgumentException('Height must be positive');
        }
        
        return $weight / ($height * $height);
    }
}

if (!function_exists('math_compound_interest')) {
    /**
     * Calculate compound interest
     * 
     * @param float $principal Initial amount
     * @param float $rate Annual interest rate (as decimal)
     * @param int $time Time in years
     * @param int $compoundsPerYear Number of times interest compounds per year
     * @return float Final amount
     */
    function math_compound_interest(float $principal, float $rate, int $time, int $compoundsPerYear = 1): float
    {
        return $principal * pow(1 + ($rate / $compoundsPerYear), $compoundsPerYear * $time);
    }
}

if (!function_exists('math_permutation')) {
    /**
     * Calculate permutation (nPr)
     * 
     * @param int $n Total items
     * @param int $r Items to arrange
     * @return int Number of permutations
     */
    function math_permutation(int $n, int $r): int
    {
        if ($r > $n || $r < 0) {
            return 0;
        }
        
        return math_factorial($n) / math_factorial($n - $r);
    }
}

if (!function_exists('math_combination')) {
    /**
     * Calculate combination (nCr)
     * 
     * @param int $n Total items
     * @param int $r Items to choose
     * @return int Number of combinations
     */
    function math_combination(int $n, int $r): int
    {
        if ($r > $n || $r < 0) {
            return 0;
        }
        
        return math_factorial($n) / (math_factorial($r) * math_factorial($n - $r));
    }
}

if (!function_exists('math_quadratic_roots')) {
    /**
     * Calculate roots of quadratic equation ax² + bx + c = 0
     * 
     * @param float $a Coefficient of x²
     * @param float $b Coefficient of x
     * @param float $c Constant term
     * @return array Array of roots
     */
    function math_quadratic_roots(float $a, float $b, float $c): array
    {
        if ($a === 0) {
            throw new InvalidArgumentException('Coefficient a cannot be zero');
        }
        
        $discriminant = $b * $b - 4 * $a * $c;
        
        if ($discriminant < 0) {
            return []; // No real roots
        }
        
        if ($discriminant === 0) {
            return [-$b / (2 * $a)]; // One real root
        }
        
        $sqrtDiscriminant = sqrt($discriminant);
        return [
            (-$b + $sqrtDiscriminant) / (2 * $a),
            (-$b - $sqrtDiscriminant) / (2 * $a)
        ];
    }
}

if (!function_exists('math_distance_2d')) {
    /**
     * Calculate distance between two 2D points
     * 
     * @param float $x1 X coordinate of first point
     * @param float $y1 Y coordinate of first point
     * @param float $x2 X coordinate of second point
     * @param float $y2 Y coordinate of second point
     * @return float Distance
     */
    function math_distance_2d(float $x1, float $y1, float $x2, float $y2): float
    {
        return sqrt(pow($x2 - $x1, 2) + pow($y2 - $y1, 2));
    }
}

if (!function_exists('math_distance_3d')) {
    /**
     * Calculate distance between two 3D points
     * 
     * @param float $x1 X coordinate of first point
     * @param float $y1 Y coordinate of first point
     * @param float $z1 Z coordinate of first point
     * @param float $x2 X coordinate of second point
     * @param float $y2 Y coordinate of second point
     * @param float $z2 Z coordinate of second point
     * @return float Distance
     */
    function math_distance_3d(float $x1, float $y1, float $z1, float $x2, float $y2, float $z2): float
    {
        return sqrt(pow($x2 - $x1, 2) + pow($y2 - $y1, 2) + pow($z2 - $z1, 2));
    }
}

if (!function_exists('math_angle_between_vectors')) {
    /**
     * Calculate angle between two 2D vectors
     * 
     * @param float $x1 X component of first vector
     * @param float $y1 Y component of first vector
     * @param float $x2 X component of second vector
     * @param float $y2 Y component of second vector
     * @return float Angle in radians
     */
    function math_angle_between_vectors(float $x1, float $y1, float $x2, float $y2): float
    {
        $dotProduct = $x1 * $x2 + $y1 * $y2;
        $magnitude1 = sqrt($x1 * $x1 + $y1 * $y1);
        $magnitude2 = sqrt($x2 * $x2 + $y2 * $y2);
        
        if ($magnitude1 === 0 || $magnitude2 === 0) {
            return 0;
        }
        
        $cosAngle = $dotProduct / ($magnitude1 * $magnitude2);
        return acos(max(-1, min(1, $cosAngle)));
    }
}

if (!function_exists('math_degrees_to_radians')) {
    /**
     * Convert degrees to radians
     * 
     * @param float $degrees Angle in degrees
     * @return float Angle in radians
     */
    function math_degrees_to_radians(float $degrees): float
    {
        return $degrees * (M_PI / 180);
    }
}

if (!function_exists('math_radians_to_degrees')) {
    /**
     * Convert radians to degrees
     * 
     * @param float $radians Angle in radians
     * @return float Angle in degrees
     */
    function math_radians_to_degrees(float $radians): float
    {
        return $radians * (180 / M_PI);
    }
}

if (!function_exists('math_normalize_angle')) {
    /**
     * Normalize angle to 0-360 degrees
     * 
     * @param float $angle Angle in degrees
     * @return float Normalized angle
     */
    function math_normalize_angle(float $angle): float
    {
        while ($angle < 0) {
            $angle += 360;
        }
        while ($angle >= 360) {
            $angle -= 360;
        }
        
        return $angle;
    }
}

if (!function_exists('math_round_to_nearest')) {
    /**
     * Round number to nearest multiple
     * 
     * @param float $number The number to round
     * @param float $multiple The multiple to round to
     * @return float Rounded number
     */
    function math_round_to_nearest(float $number, float $multiple): float
    {
        if ($multiple === 0) {
            return $number;
        }
        
        return round($number / $multiple) * $multiple;
    }
}

if (!function_exists('math_clamp')) {
    /**
     * Clamp number between min and max values
     * 
     * @param float $number The number to clamp
     * @param float $min Minimum value
     * @param float $max Maximum value
     * @return float Clamped number
     */
    function math_clamp(float $number, float $min, float $max): float
    {
        return max($min, min($max, $number));
    }
}
