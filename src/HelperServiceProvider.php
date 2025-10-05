<?php

namespace Subhashladumor\LaravelHelperbox;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register helper files
        $this->loadHelpers();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Register Blade directives
        $this->registerBladeDirectives();
    }

    /**
     * Load all helper files
     *
     * @return void
     */
    protected function loadHelpers()
    {
        $helperFiles = [
            'ArrayHelpers',
            'StringHelpers',
            'MathHelpers',
            'BladeHelpers',
            'ModelDatabaseHelpers',
            'FilePathHelpers',
            'MemorySystemHelpers',
            'ControllerRepositoryHelpers',
            'DateTimeHelpers',
            'CacheSessionHelpers',
            'ApiHttpHelpers',
            'ValidationHelpers',
            'AdvancedAlgorithmHelpers',
            'AdvancedStringParsingHelpers',
            'AdvancedMathAlgorithmicHelpers',
            'AdvancedLaravelDatabaseHelpers',
            'JsStyleHelpers',
            'AdvancedCacheHelpers',
            'FileStreamingHelpers',
            'SystemMonitoringOptimizationHelpers',
            'SecurityAuthHelpers',
            'AdvancedDeveloperHelpers',
            'ThirdPartyApiHelpers',
            'SqlOptimizationHelpers',
            'DataScienceAnalyticsHelpers',
            'FrontendOptimizationHelpers',
            'GeoHelpers',
        ];

        foreach ($helperFiles as $helperFile) {
            $filePath = __DIR__ . "/Helpers/{$helperFile}.php";
            if (file_exists($filePath)) {
                require_once $filePath;
            }
        }
    }

    /**
     * Register custom Blade directives
     *
     * @return void
     */
    protected function registerBladeDirectives()
    {
        // Register blade helper directives
        if (function_exists('blade_if_route')) {
            Blade::directive('ifroute', function ($expression) {
                return "<?php if(blade_if_route($expression)): ?>";
            });
            
            Blade::directive('endifroute', function () {
                return '<?php endif; ?>';
            });
        }

        if (function_exists('blade_if_controller')) {
            Blade::directive('ifcontroller', function ($expression) {
                return "<?php if(blade_if_controller($expression)): ?>";
            });
            
            Blade::directive('endifcontroller', function () {
                return '<?php endif; ?>';
            });
        }

        if (function_exists('blade_if_role')) {
            Blade::directive('ifrole', function ($expression) {
                return "<?php if(blade_if_role($expression)): ?>";
            });
            
            Blade::directive('endifrole', function () {
                return '<?php endif; ?>';
            });
        }

        if (function_exists('blade_if_permission')) {
            Blade::directive('ifpermission', function ($expression) {
                return "<?php if(blade_if_permission($expression)): ?>";
            });
            
            Blade::directive('endifpermission', function () {
                return '<?php endif; ?>';
            });
        }
    }
}
