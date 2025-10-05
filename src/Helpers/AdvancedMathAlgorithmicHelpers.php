<?php

/**
 * Advanced Math & Algorithmic Helper Functions
 * 
 * This file contains 40+ advanced mathematical and algorithmic functions
 * for complex calculations, machine learning utilities, and advanced algorithms.
 * 
 * @package Subhashladumor\LaravelHelperbox
 * @author Subhash Ladumor
 */

if (!function_exists('math_gcd_extended')) {
    /**
     * Extended Euclidean algorithm
     * 
     * @param int $a First number
     * @param int $b Second number
     * @return array Array with gcd, x, y coefficients
     */
    function math_gcd_extended(int $a, int $b): array
    {
        if ($a === 0) {
            return ['gcd' => $b, 'x' => 0, 'y' => 1];
        }
        
        $result = math_gcd_extended($b % $a, $a);
        $x = $result['y'] - intval($b / $a) * $result['x'];
        $y = $result['x'];
        
        return [
            'gcd' => $result['gcd'],
            'x' => $x,
            'y' => $y
        ];
    }
}

if (!function_exists('math_is_prime_miller_rabin')) {
    /**
     * Probabilistic primality test using Miller-Rabin
     * 
     * @param int $n Number to test
     * @param int $k Number of iterations
     * @return bool True if probably prime
     */
    function math_is_prime_miller_rabin(int $n, int $k = 5): bool
    {
        if ($n <= 1 || $n === 4) return false;
        if ($n <= 3) return true;
        if ($n % 2 === 0) return false;
        
        $d = $n - 1;
        while ($d % 2 === 0) {
            $d /= 2;
        }
        
        for ($i = 0; $i < $k; $i++) {
            $a = random_int(2, $n - 2);
            $x = math_modular_pow($a, $d, $n);
            
            if ($x === 1 || $x === $n - 1) continue;
            
            $continue = false;
            for ($j = 0; $j < $d - 1; $j++) {
                $x = ($x * $x) % $n;
                if ($x === $n - 1) {
                    $continue = true;
                    break;
                }
            }
            
            if (!$continue) return false;
        }
        
        return true;
    }
}

if (!function_exists('math_generate_primes_sieve')) {
    /**
     * Generate primes using Sieve of Eratosthenes
     * 
     * @param int $n Upper limit
     * @return array Array of primes
     */
    function math_generate_primes_sieve(int $n): array
    {
        if ($n < 2) return [];
        
        $sieve = array_fill(0, $n + 1, true);
        $sieve[0] = $sieve[1] = false;
        
        for ($i = 2; $i * $i <= $n; $i++) {
            if ($sieve[$i]) {
                for ($j = $i * $i; $j <= $n; $j += $i) {
                    $sieve[$j] = false;
                }
            }
        }
        
        $primes = [];
        for ($i = 2; $i <= $n; $i++) {
            if ($sieve[$i]) {
                $primes[] = $i;
            }
        }
        
        return $primes;
    }
}

if (!function_exists('math_factorial_bigint')) {
    /**
     * Compute factorial for very large numbers
     * 
     * @param int $n Number
     * @return string Factorial as string
     */
    function math_factorial_bigint(int $n): string
    {
        if ($n < 0) return '0';
        if ($n <= 1) return '1';
        
        $result = '1';
        for ($i = 2; $i <= $n; $i++) {
            $result = bcmul($result, (string)$i);
        }
        
        return $result;
    }
}

if (!function_exists('math_modular_inverse')) {
    /**
     * Find modular inverse using extended Euclidean algorithm
     * 
     * @param int $a Number
     * @param int $m Modulus
     * @return int|false Modular inverse or false if doesn't exist
     */
    function math_modular_inverse(int $a, int $m): int|false
    {
        $result = math_gcd_extended($a, $m);
        
        if ($result['gcd'] !== 1) {
            return false; // Modular inverse doesn't exist
        }
        
        return ($result['x'] % $m + $m) % $m;
    }
}

if (!function_exists('math_modular_pow')) {
    /**
     * Fast modular exponentiation
     * 
     * @param int $base Base
     * @param int $exp Exponent
     * @param int $mod Modulus
     * @return int Result
     */
    function math_modular_pow(int $base, int $exp, int $mod): int
    {
        $result = 1;
        $base = $base % $mod;
        
        while ($exp > 0) {
            if ($exp % 2 === 1) {
                $result = ($result * $base) % $mod;
            }
            $exp = $exp >> 1;
            $base = ($base * $base) % $mod;
        }
        
        return $result;
    }
}

if (!function_exists('math_fibonacci_matrix')) {
    /**
     * Fibonacci using matrix exponentiation
     * 
     * @param int $n Position in Fibonacci sequence
     * @return int Fibonacci number
     */
    function math_fibonacci_matrix(int $n): int
    {
        if ($n <= 1) return $n;
        
        $matrix = [[1, 1], [1, 0]];
        $result = math_matrix_pow($matrix, $n - 1);
        
        return $result[0][0];
    }
}

if (!function_exists('math_polynomial_evaluate')) {
    /**
     * Evaluate polynomial at given point
     * 
     * @param array $coeffs Coefficients (highest degree first)
     * @param float $x Point to evaluate
     * @return float Result
     */
    function math_polynomial_evaluate(array $coeffs, float $x): float
    {
        $result = 0;
        $degree = count($coeffs) - 1;
        
        for ($i = 0; $i <= $degree; $i++) {
            $result += $coeffs[$i] * pow($x, $degree - $i);
        }
        
        return $result;
    }
}

if (!function_exists('math_interpolation_lagrange')) {
    /**
     * Polynomial interpolation using Lagrange method
     * 
     * @param array $points Array of [x, y] points
     * @return array Coefficients of interpolating polynomial
     */
    function math_interpolation_lagrange(array $points): array
    {
        $n = count($points);
        $coeffs = array_fill(0, $n, 0);
        
        for ($i = 0; $i < $n; $i++) {
            $term = array_fill(0, $n, 0);
            $term[0] = $points[$i][1];
            
            for ($j = 0; $j < $n; $j++) {
                if ($i !== $j) {
                    $factor = 1 / ($points[$i][0] - $points[$j][0]);
                    $temp = array_fill(0, $n, 0);
                    $temp[0] = -$points[$j][0] * $factor;
                    $temp[1] = $factor;
                    
                    $term = math_polynomial_multiply($term, $temp, $n);
                }
            }
            
            for ($k = 0; $k < $n; $k++) {
                $coeffs[$k] += $term[$k];
            }
        }
        
        return $coeffs;
    }
}

if (!function_exists('math_determinant')) {
    /**
     * Compute determinant of matrix
     * 
     * @param array $matrix Square matrix
     * @return float Determinant
     */
    function math_determinant(array $matrix): float
    {
        $n = count($matrix);
        
        if ($n === 1) {
            return $matrix[0][0];
        }
        
        if ($n === 2) {
            return $matrix[0][0] * $matrix[1][1] - $matrix[0][1] * $matrix[1][0];
        }
        
        $det = 0;
        for ($i = 0; $i < $n; $i++) {
            $submatrix = [];
            for ($j = 1; $j < $n; $j++) {
                $row = [];
                for ($k = 0; $k < $n; $k++) {
                    if ($k !== $i) {
                        $row[] = $matrix[$j][$k];
                    }
                }
                $submatrix[] = $row;
            }
            
            $det += pow(-1, $i) * $matrix[0][$i] * math_determinant($submatrix);
        }
        
        return $det;
    }
}

if (!function_exists('math_matrix_inverse')) {
    /**
     * Compute matrix inverse using Gaussian elimination
     * 
     * @param array $matrix Square matrix
     * @return array|false Inverse matrix or false if singular
     */
    function math_matrix_inverse(array $matrix): array|false
    {
        $n = count($matrix);
        $identity = array_fill(0, $n, array_fill(0, $n, 0));
        
        for ($i = 0; $i < $n; $i++) {
            $identity[$i][$i] = 1;
        }
        
        // Create augmented matrix
        $augmented = [];
        for ($i = 0; $i < $n; $i++) {
            $augmented[$i] = array_merge($matrix[$i], $identity[$i]);
        }
        
        // Gaussian elimination
        for ($i = 0; $i < $n; $i++) {
            // Find pivot
            $maxRow = $i;
            for ($k = $i + 1; $k < $n; $k++) {
                if (abs($augmented[$k][$i]) > abs($augmented[$maxRow][$i])) {
                    $maxRow = $k;
                }
            }
            
            // Swap rows
            [$augmented[$i], $augmented[$maxRow]] = [$augmented[$maxRow], $augmented[$i]];
            
            if (abs($augmented[$i][$i]) < 1e-10) {
                return false; // Singular matrix
            }
            
            // Make diagonal element 1
            $pivot = $augmented[$i][$i];
            for ($j = 0; $j < 2 * $n; $j++) {
                $augmented[$i][$j] /= $pivot;
            }
            
            // Eliminate column
            for ($k = 0; $k < $n; $k++) {
                if ($k !== $i) {
                    $factor = $augmented[$k][$i];
                    for ($j = 0; $j < 2 * $n; $j++) {
                        $augmented[$k][$j] -= $factor * $augmented[$i][$j];
                    }
                }
            }
        }
        
        // Extract inverse matrix
        $inverse = [];
        for ($i = 0; $i < $n; $i++) {
            $inverse[$i] = array_slice($augmented[$i], $n);
        }
        
        return $inverse;
    }
}

if (!function_exists('math_matrix_multiply')) {
    /**
     * Multiply two matrices
     * 
     * @param array $a First matrix
     * @param array $b Second matrix
     * @return array Result matrix
     */
    function math_matrix_multiply(array $a, array $b): array
    {
        $rowsA = count($a);
        $colsA = count($a[0]);
        $colsB = count($b[0]);
        
        $result = array_fill(0, $rowsA, array_fill(0, $colsB, 0));
        
        for ($i = 0; $i < $rowsA; $i++) {
            for ($j = 0; $j < $colsB; $j++) {
                for ($k = 0; $k < $colsA; $k++) {
                    $result[$i][$j] += $a[$i][$k] * $b[$k][$j];
                }
            }
        }
        
        return $result;
    }
}

if (!function_exists('math_convex_hull')) {
    /**
     * Compute convex hull using Graham scan
     * 
     * @param array $points Array of [x, y] points
     * @return array Convex hull points
     */
    function math_convex_hull(array $points): array
    {
        if (count($points) < 3) {
            return $points;
        }
        
        // Find bottom-most point
        $bottom = 0;
        for ($i = 1; $i < count($points); $i++) {
            if ($points[$i][1] < $points[$bottom][1] || 
                ($points[$i][1] === $points[$bottom][1] && $points[$i][0] < $points[$bottom][0])) {
                $bottom = $i;
            }
        }
        
        // Swap bottom point to first position
        [$points[0], $points[$bottom]] = [$points[$bottom], $points[0]];
        
        // Sort by polar angle
        usort($points, function($a, $b) use ($points) {
            $angleA = atan2($a[1] - $points[0][1], $a[0] - $points[0][0]);
            $angleB = atan2($b[1] - $points[0][1], $b[0] - $points[0][0]);
            return $angleA <=> $angleB;
        });
        
        // Build convex hull
        $hull = [];
        $hull[] = $points[0];
        $hull[] = $points[1];
        
        for ($i = 2; $i < count($points); $i++) {
            while (count($hull) > 1 && 
                   math_cross_product($hull[count($hull) - 2], $hull[count($hull) - 1], $points[$i]) <= 0) {
                array_pop($hull);
            }
            $hull[] = $points[$i];
        }
        
        return $hull;
    }
}

if (!function_exists('math_fast_fourier_transform')) {
    /**
     * Fast Fourier Transform
     * 
     * @param array $real Real parts
     * @param array $imag Imaginary parts
     * @return array FFT result
     */
    function math_fast_fourier_transform(array $real, array $imag): array
    {
        $n = count($real);
        
        if ($n === 1) {
            return ['real' => $real, 'imag' => $imag];
        }
        
        // Ensure n is power of 2
        $nextPower = 1;
        while ($nextPower < $n) {
            $nextPower *= 2;
        }
        
        // Pad arrays
        $real = array_pad($real, $nextPower, 0);
        $imag = array_pad($imag, $nextPower, 0);
        
        return fft_recursive($real, $imag, $nextPower);
    }
}

if (!function_exists('math_random_gaussian')) {
    /**
     * Generate Gaussian distributed random numbers using Box-Muller transform
     * 
     * @param float $mean Mean
     * @param float $stddev Standard deviation
     * @return float Random number
     */
    function math_random_gaussian(float $mean = 0, float $stddev = 1): float
    {
        static $spare = null;
        static $hasSpare = false;
        
        if ($hasSpare) {
            $hasSpare = false;
            return $spare * $stddev + $mean;
        }
        
        $hasSpare = true;
        $u = mt_rand() / mt_getrandmax();
        $v = mt_rand() / mt_getrandmax();
        
        $mag = $stddev * sqrt(-2 * log($u));
        $spare = $mag * cos(2 * M_PI * $v);
        
        return $mag * sin(2 * M_PI * $v) + $mean;
    }
}

if (!function_exists('math_combinations')) {
    /**
     * Generate all k-combinations
     * 
     * @param array $array Input array
     * @param int $k Size of combinations
     * @return array Array of combinations
     */
    function math_combinations(array $array, int $k): array
    {
        if ($k === 0) return [[]];
        if ($k > count($array)) return [];
        if ($k === count($array)) return [$array];
        
        $combinations = [];
        $n = count($array);
        
        for ($i = 0; $i < $n - $k + 1; $i++) {
            $subCombinations = math_combinations(array_slice($array, $i + 1), $k - 1);
            foreach ($subCombinations as $combo) {
                array_unshift($combo, $array[$i]);
                $combinations[] = $combo;
            }
        }
        
        return $combinations;
    }
}

if (!function_exists('math_permutations')) {
    /**
     * Generate all permutations
     * 
     * @param array $array Input array
     * @return array Array of permutations
     */
    function math_permutations(array $array): array
    {
        if (count($array) <= 1) return [$array];
        
        $permutations = [];
        $n = count($array);
        
        for ($i = 0; $i < $n; $i++) {
            $rest = array_merge(array_slice($array, 0, $i), array_slice($array, $i + 1));
            $subPermutations = math_permutations($rest);
            
            foreach ($subPermutations as $perm) {
                array_unshift($perm, $array[$i]);
                $permutations[] = $perm;
            }
        }
        
        return $permutations;
    }
}

if (!function_exists('math_power_set')) {
    /**
     * Generate all subsets (power set)
     * 
     * @param array $array Input array
     * @return array Array of all subsets
     */
    function math_power_set(array $array): array
    {
        $n = count($array);
        $powerSet = [];
        
        for ($i = 0; $i < (1 << $n); $i++) {
            $subset = [];
            for ($j = 0; $j < $n; $j++) {
                if ($i & (1 << $j)) {
                    $subset[] = $array[$j];
                }
            }
            $powerSet[] = $subset;
        }
        
        return $powerSet;
    }
}

if (!function_exists('math_knapsack')) {
    /**
     * Solve 0/1 knapsack problem
     * 
     * @param array $weights Item weights
     * @param array $values Item values
     * @param int $capacity Knapsack capacity
     * @return array Maximum value and selected items
     */
    function math_knapsack(array $weights, array $values, int $capacity): array
    {
        $n = count($weights);
        $dp = array_fill(0, $n + 1, array_fill(0, $capacity + 1, 0));
        
        for ($i = 1; $i <= $n; $i++) {
            for ($w = 1; $w <= $capacity; $w++) {
                if ($weights[$i - 1] <= $w) {
                    $dp[$i][$w] = max(
                        $dp[$i - 1][$w],
                        $dp[$i - 1][$w - $weights[$i - 1]] + $values[$i - 1]
                    );
                } else {
                    $dp[$i][$w] = $dp[$i - 1][$w];
                }
            }
        }
        
        // Find selected items
        $selected = [];
        $w = $capacity;
        for ($i = $n; $i > 0 && $w > 0; $i--) {
            if ($dp[$i][$w] !== $dp[$i - 1][$w]) {
                $selected[] = $i - 1;
                $w -= $weights[$i - 1];
            }
        }
        
        return [
            'max_value' => $dp[$n][$capacity],
            'selected_items' => array_reverse($selected)
        ];
    }
}

if (!function_exists('math_coin_change')) {
    /**
     * Find minimum coins required for change
     * 
     * @param array $coins Available coin denominations
     * @param int $amount Target amount
     * @return int Minimum number of coins
     */
    function math_coin_change(array $coins, int $amount): int
    {
        $dp = array_fill(0, $amount + 1, PHP_INT_MAX);
        $dp[0] = 0;
        
        for ($i = 1; $i <= $amount; $i++) {
            foreach ($coins as $coin) {
                if ($coin <= $i && $dp[$i - $coin] !== PHP_INT_MAX) {
                    $dp[$i] = min($dp[$i], $dp[$i - $coin] + 1);
                }
            }
        }
        
        return $dp[$amount] === PHP_INT_MAX ? -1 : $dp[$amount];
    }
}

if (!function_exists('math_simplex')) {
    /**
     * Solve linear programming problem using simplex method
     * 
     * @param array $objective Objective function coefficients
     * @param array $constraints Constraint matrix
     * @param array $rhs Right-hand side values
     * @return array|false Solution or false if infeasible
     */
    function math_simplex(array $objective, array $constraints, array $rhs): array|false
    {
        // This is a simplified implementation
        // Real simplex method is more complex
        
        $n = count($objective);
        $m = count($constraints);
        
        // Create tableau
        $tableau = [];
        for ($i = 0; $i < $m; $i++) {
            $row = array_merge($constraints[$i], array_fill(0, $m, 0));
            $row[$n + $i] = 1; // Slack variables
            $row[] = $rhs[$i];
            $tableau[] = $row;
        }
        
        // Add objective row
        $objRow = array_merge($objective, array_fill(0, $m, 0));
        $objRow[] = 0;
        $tableau[] = $objRow;
        
        // Simplex iterations
        $iterations = 0;
        $maxIterations = 100;
        
        while ($iterations < $maxIterations) {
            // Find entering variable (most negative in objective row)
            $entering = -1;
            $minValue = 0;
            
            for ($j = 0; $j < $n + $m; $j++) {
                if ($tableau[$m][$j] < $minValue) {
                    $minValue = $tableau[$m][$j];
                    $entering = $j;
                }
            }
            
            if ($entering === -1) {
                break; // Optimal solution found
            }
            
            // Find leaving variable
            $leaving = -1;
            $minRatio = PHP_FLOAT_MAX;
            
            for ($i = 0; $i < $m; $i++) {
                if ($tableau[$i][$entering] > 0) {
                    $ratio = $tableau[$i][$n + $m] / $tableau[$i][$entering];
                    if ($ratio < $minRatio) {
                        $minRatio = $ratio;
                        $leaving = $i;
                    }
                }
            }
            
            if ($leaving === -1) {
                return false; // Unbounded solution
            }
            
            // Pivot
            $pivot = $tableau[$leaving][$entering];
            for ($j = 0; $j <= $n + $m; $j++) {
                $tableau[$leaving][$j] /= $pivot;
            }
            
            for ($i = 0; $i <= $m; $i++) {
                if ($i !== $leaving) {
                    $factor = $tableau[$i][$entering];
                    for ($j = 0; $j <= $n + $m; $j++) {
                        $tableau[$i][$j] -= $factor * $tableau[$leaving][$j];
                    }
                }
            }
            
            $iterations++;
        }
        
        // Extract solution
        $solution = array_fill(0, $n, 0);
        for ($i = 0; $i < $m; $i++) {
            $basic = -1;
            for ($j = 0; $j < $n; $j++) {
                if (abs($tableau[$i][$j] - 1) < 1e-10) {
                    $basic = $j;
                    break;
                }
            }
            if ($basic !== -1) {
                $solution[$basic] = $tableau[$i][$n + $m];
            }
        }
        
        return [
            'solution' => $solution,
            'objective_value' => -$tableau[$m][$n + $m]
        ];
    }
}

// Helper functions for the algorithms above

if (!function_exists('math_polynomial_multiply')) {
    function math_polynomial_multiply(array $a, array $b, int $maxDegree): array
    {
        $result = array_fill(0, $maxDegree, 0);
        
        for ($i = 0; $i < count($a); $i++) {
            for ($j = 0; $j < count($b) && $i + $j < $maxDegree; $j++) {
                $result[$i + $j] += $a[$i] * $b[$j];
            }
        }
        
        return $result;
    }
}

if (!function_exists('math_cross_product')) {
    function math_cross_product(array $O, array $A, array $B): float
    {
        return ($A[0] - $O[0]) * ($B[1] - $O[1]) - ($A[1] - $O[1]) * ($B[0] - $O[0]);
    }
}

if (!function_exists('fft_recursive')) {
    function fft_recursive(array $real, array $imag, int $n): array
    {
        if ($n === 1) {
            return ['real' => $real, 'imag' => $imag];
        }
        
        // Split into even and odd
        $evenReal = [];
        $evenImag = [];
        $oddReal = [];
        $oddImag = [];
        
        for ($i = 0; $i < $n; $i += 2) {
            $evenReal[] = $real[$i];
            $evenImag[] = $imag[$i];
            $oddReal[] = $real[$i + 1];
            $oddImag[] = $imag[$i + 1];
        }
        
        $evenFFT = fft_recursive($evenReal, $evenImag, $n / 2);
        $oddFFT = fft_recursive($oddReal, $oddImag, $n / 2);
        
        $resultReal = array_fill(0, $n, 0);
        $resultImag = array_fill(0, $n, 0);
        
        for ($i = 0; $i < $n / 2; $i++) {
            $angle = -2 * M_PI * $i / $n;
            $cos = cos($angle);
            $sin = sin($angle);
            
            $tempReal = $cos * $oddFFT['real'][$i] - $sin * $oddFFT['imag'][$i];
            $tempImag = $cos * $oddFFT['imag'][$i] + $sin * $oddFFT['real'][$i];
            
            $resultReal[$i] = $evenFFT['real'][$i] + $tempReal;
            $resultImag[$i] = $evenFFT['imag'][$i] + $tempImag;
            $resultReal[$i + $n / 2] = $evenFFT['real'][$i] - $tempReal;
            $resultImag[$i + $n / 2] = $evenFFT['imag'][$i] - $tempImag;
        }
        
        return ['real' => $resultReal, 'imag' => $resultImag];
    }
}

if (!function_exists('math_matrix_pow')) {
    function math_matrix_pow(array $matrix, int $n): array
    {
        if ($n === 0) {
            $size = count($matrix);
            $identity = array_fill(0, $size, array_fill(0, $size, 0));
            for ($i = 0; $i < $size; $i++) {
                $identity[$i][$i] = 1;
            }
            return $identity;
        }
        
        if ($n === 1) {
            return $matrix;
        }
        
        if ($n % 2 === 0) {
            $half = math_matrix_pow($matrix, $n / 2);
            return math_matrix_multiply($half, $half);
        } else {
            return math_matrix_multiply($matrix, math_matrix_pow($matrix, $n - 1));
        }
    }
}
