### DataScienceAnalyticsHelpers

Core statistics and simple ML building-blocks: normalization, correlation, regression, smoothing, k-means, and metrics.

#### Function Index

- ds_mean(array $values): float
- ds_median(array $values): float
- ds_mode(array $values): mixed
- ds_stddev(array $values, bool $sample = false): float
- ds_normalize_minmax(array $values): array
- ds_correlation(array $x, array $y): float
- ds_linear_regression(array $x, array $y): array
- ds_moving_average(array $values, int $window): array
- ds_exp_smoothing(array $values, float $alpha = 0.3): array
- ds_kmeans(array $points, int $k = 2, int $iterations = 10): array
- ds_confusion_matrix(array $yTrue, array $yPred): array


