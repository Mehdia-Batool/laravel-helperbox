<?php

/**
 * Data Science & Analytics Helpers
 *
 * Mean/median/mode, stddev, normalization, correlation, simple linear
 * regression, moving average, exponential smoothing, k-means, confusion matrix.
 *
 * @package Subhashladumor\LaravelHelperbox
 */

if (!function_exists('ds_mean')) {
    function ds_mean(array $values): float
    {
        $n = count($values); if ($n === 0) return 0.0; return array_sum($values) / $n;
    }
}

if (!function_exists('ds_median')) {
    function ds_median(array $values): float
    {
        $n = count($values); if ($n === 0) return 0.0; sort($values); $m = intdiv($n, 2);
        return $n % 2 ? (float) $values[$m] : ($values[$m - 1] + $values[$m]) / 2.0;
    }
}

if (!function_exists('ds_mode')) {
    function ds_mode(array $values): mixed
    {
        if (!$values) return null; $counts = array_count_values($values); arsort($counts); return array_key_first($counts);
    }
}

if (!function_exists('ds_stddev')) {
    function ds_stddev(array $values, bool $sample = false): float
    {
        $n = count($values); if ($n <= ($sample ? 1 : 0)) return 0.0; $mean = ds_mean($values);
        $sum = 0.0; foreach ($values as $v) { $sum += ($v - $mean) ** 2; }
        return sqrt($sum / ($sample ? ($n - 1) : $n));
    }
}

if (!function_exists('ds_normalize_minmax')) {
    function ds_normalize_minmax(array $values): array
    {
        if (!$values) return []; $min = min($values); $max = max($values); if ($max === $min) return array_fill(0, count($values), 0);
        return array_map(fn($v) => ($v - $min) / ($max - $min), $values);
    }
}

if (!function_exists('ds_correlation')) {
    function ds_correlation(array $x, array $y): float
    {
        $n = min(count($x), count($y)); if ($n === 0) return 0.0;
        $x = array_slice($x, 0, $n); $y = array_slice($y, 0, $n);
        $mx = ds_mean($x); $my = ds_mean($y);
        $num = 0.0; $dx = 0.0; $dy = 0.0;
        for ($i = 0; $i < $n; $i++) { $vx = $x[$i] - $mx; $vy = $y[$i] - $my; $num += $vx * $vy; $dx += $vx * $vx; $dy += $vy * $vy; }
        return ($dx > 0 && $dy > 0) ? $num / sqrt($dx * $dy) : 0.0;
    }
}

if (!function_exists('ds_linear_regression')) {
    function ds_linear_regression(array $x, array $y): array
    {
        $n = min(count($x), count($y)); if ($n === 0) return ['slope' => 0.0, 'intercept' => 0.0];
        $x = array_slice($x, 0, $n); $y = array_slice($y, 0, $n);
        $mx = ds_mean($x); $my = ds_mean($y);
        $num = 0.0; $den = 0.0; for ($i = 0; $i < $n; $i++) { $dx = $x[$i] - $mx; $num += $dx * ($y[$i] - $my); $den += $dx * $dx; }
        $slope = $den != 0 ? $num / $den : 0.0; $intercept = $my - $slope * $mx; return ['slope' => $slope, 'intercept' => $intercept];
    }
}

if (!function_exists('ds_moving_average')) {
    function ds_moving_average(array $values, int $window): array
    {
        $n = count($values); if ($window <= 0 || $n === 0) return []; $res = [];
        for ($i = 0; $i <= $n - $window; $i++) { $res[] = ds_mean(array_slice($values, $i, $window)); }
        return $res;
    }
}

if (!function_exists('ds_exp_smoothing')) {
    function ds_exp_smoothing(array $values, float $alpha = 0.3): array
    {
        if (!$values) return []; $s = [$values[0]]; for ($i = 1; $i < count($values); $i++) { $s[$i] = $alpha * $values[$i] + (1 - $alpha) * $s[$i - 1]; } return $s;
    }
}

if (!function_exists('ds_kmeans')) {
    function ds_kmeans(array $points, int $k = 2, int $iterations = 10): array
    {
        if ($k <= 0 || !$points) return ['centroids' => [], 'clusters' => []];
        // Initialize centroids as first k points
        $centroids = array_slice($points, 0, $k);
        $clusters = [];
        for ($it = 0; $it < $iterations; $it++) {
            $clusters = array_fill(0, $k, []);
            // Assign
            foreach ($points as $p) {
                $minD = PHP_FLOAT_MAX; $ci = 0;
                foreach ($centroids as $i => $c) {
                    $d = 0.0; for ($j = 0; $j < count($p); $j++) { $d += ($p[$j] - $c[$j]) ** 2; }
                    if ($d < $minD) { $minD = $d; $ci = $i; }
                }
                $clusters[$ci][] = $p;
            }
            // Recompute centroids
            for ($i = 0; $i < $k; $i++) {
                if (!$clusters[$i]) continue;
                $dims = count($clusters[$i][0]); $avg = array_fill(0, $dims, 0.0);
                foreach ($clusters[$i] as $p) { for ($j = 0; $j < $dims; $j++) { $avg[$j] += $p[$j]; } }
                for ($j = 0; $j < $dims; $j++) { $avg[$j] /= max(1, count($clusters[$i])); }
                $centroids[$i] = $avg;
            }
        }
        return ['centroids' => $centroids, 'clusters' => $clusters];
    }
}

if (!function_exists('ds_confusion_matrix')) {
    function ds_confusion_matrix(array $yTrue, array $yPred): array
    {
        $tp = 0; $tn = 0; $fp = 0; $fn = 0;
        $n = min(count($yTrue), count($yPred));
        for ($i = 0; $i < $n; $i++) {
            $t = (bool) $yTrue[$i]; $p = (bool) $yPred[$i];
            if ($t && $p) $tp++; elseif (!$t && !$p) $tn++; elseif (!$t && $p) $fp++; else $fn++;
        }
        return ['tp' => $tp, 'tn' => $tn, 'fp' => $fp, 'fn' => $fn];
    }
}

?>


