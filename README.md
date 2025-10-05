## 🚀 Laravel HelperBox — 600+ Powerful Laravel Helper Functions

Make Laravel development faster, cleaner, and more productive. Laravel HelperBox ships 600+ high-quality helper functions across arrays, strings, dates, Blade, Eloquent/database, caching, HTTP/APIs, security, math/algorithms, data science, geo utilities, frontend optimizations, system monitoring, and more.

Built for modern Laravel (9–12), fully framework-native, no macros or monoliths — just handy, well-named functions you can drop into any project.

### ✨ Highlights
- 600+ unique helpers not in PHP or Laravel core
- Organized into focused categories in `src/Helpers`
- Autoloaded via `HelperServiceProvider` — zero setup
- Production-ready: caching, DB utilities, security, performance, analytics

---

## 📦 Installation

```bash
composer require subhashladumor/laravel-helperbox
```

Laravel auto-discovers the provider: `Subhashladumor\LaravelHelperbox\HelperServiceProvider`.

---

## ⚡ Usage (quick taste)

```php
// Arrays
$flat = array_flatten_recursive([[1, [2]], 3]); // [1, 2, 3]

// Strings
$slug = str_slugify('Hello, Laravel HelperBox!'); // "hello-laravel-helperbox"

// Cache
$value = cache_with_jitter('dashboard:data', 300, 15, fn () => fetchExpensive());

// DB (detect N+1)
$report = db_detect_n_plus_one(User::query(), ['posts', 'roles']);

// HTTP
$json = http_get_json('https://api.github.com');
```

See full category documentation in the docs below.

---

## 🗂 Categories (600+ helpers)

Each helper group lives in `src/Helpers/<HelperFile>.php`. Explore documentation per category:

- [ArrayHelpers](docs/ArrayHelpers.md)
- [StringHelpers](docs/StringHelpers.md)
- [MathHelpers](docs/MathHelpers.md)
- [BladeHelpers](docs/BladeHelpers.md)
- [ModelDatabaseHelpers](docs/ModelDatabaseHelpers.md)
- [FilePathHelpers](docs/FilePathHelpers.md)
- [MemorySystemHelpers](docs/MemorySystemHelpers.md)
- [ControllerRepositoryHelpers](docs/ControllerRepositoryHelpers.md)
- [DateTimeHelpers](docs/DateTimeHelpers.md)
- [CacheSessionHelpers](docs/CacheSessionHelpers.md)
- [ApiHttpHelpers](docs/ApiHttpHelpers.md)
- [ValidationHelpers](docs/ValidationHelpers.md)
- [AdvancedAlgorithmHelpers](docs/AdvancedAlgorithmHelpers.md)
- [AdvancedStringParsingHelpers](docs/AdvancedStringParsingHelpers.md)
- [AdvancedMathAlgorithmicHelpers](docs/AdvancedMathAlgorithmicHelpers.md)
- [AdvancedLaravelDatabaseHelpers](docs/AdvancedLaravelDatabaseHelpers.md)
- [JsStyleHelpers](docs/JsStyleHelpers.md)
- [AdvancedCacheHelpers](docs/AdvancedCacheHelpers.md)
- [FileStreamingHelpers](docs/FileStreamingHelpers.md)
- [SystemMonitoringOptimizationHelpers](docs/SystemMonitoringOptimizationHelpers.md)
- [SecurityAuthHelpers](docs/SecurityAuthHelpers.md)
- [AdvancedDeveloperHelpers](docs/AdvancedDeveloperHelpers.md)
- [ThirdPartyApiHelpers](docs/ThirdPartyApiHelpers.md)
- [SqlOptimizationHelpers](docs/SqlOptimizationHelpers.md)
- [DataScienceAnalyticsHelpers](docs/DataScienceAnalyticsHelpers.md)
- [FrontendOptimizationHelpers](docs/FrontendOptimizationHelpers.md)
- [GeoHelpers](docs/GeoHelpers.md)

> Total helpers: 600+ (and growing)

---

## 📖 Documentation

All categories link to `docs/<HelperFile>.md`. Each page includes:
- Overview and when to use
- Function index with signatures
- Usage examples and tips

If you prefer browsing code, see `src/Helpers/` — every function is wrapped in `function_exists` guards and can be called directly.

---

## 🛠 Contributing

Contributions are welcome! Fixes, docs, tests, and new helpers are appreciated.

1. Fork and create a feature branch
2. Add or update helpers in `src/Helpers/`
3. Include concise PHPDoc blocks and guard with `function_exists`
4. Add usage examples to the corresponding `docs/<HelperFile>.md`
5. Open a PR with a clear description

---

## 📄 License

MIT © Subhash Ladumor


