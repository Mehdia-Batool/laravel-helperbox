<?php

/**
 * Frontend Optimization Helpers
 *
 * CSS/JS minify (basic), inline critical CSS, async/defer script tags,
 * cache busting, and HTML minify.
 *
 * @package Subhashladumor\LaravelHelperbox
 */

if (!function_exists('fe_minify_css')) {
    function fe_minify_css(string $css): string
    {
        $css = preg_replace('!/\*.*?\*/!s', '', $css);
        $css = preg_replace('/\s+/', ' ', $css);
        $css = str_replace([' :', ': ', ' ;', '; '], [':', ':', ';', ';'], $css);
        return trim($css);
    }
}

if (!function_exists('fe_minify_js')) {
    function fe_minify_js(string $js): string
    {
        $js = preg_replace('!/\*.*?\*/!s', '', $js);
        $js = preg_replace('/(^|[^:])\/\/.*$/m', '$1', $js);
        $js = preg_replace('/\s+/', ' ', $js);
        return trim($js);
    }
}

if (!function_exists('fe_inline_critical_css')) {
    function fe_inline_critical_css(string $html, string $criticalCss): string
    {
        $style = '<style>' . fe_minify_css($criticalCss) . '</style>';
        return preg_replace('/<head(.*?)>/', '<head$1>' . $style, $html, 1);
    }
}

if (!function_exists('fe_async_script')) {
    function fe_async_script(string $src, bool $defer = false): string
    {
        $attr = $defer ? 'defer' : 'async';
        return '<script ' . $attr . ' src="' . htmlspecialchars($src, ENT_QUOTES, 'UTF-8') . '"></script>';
    }
}

if (!function_exists('fe_cache_bust')) {
    function fe_cache_bust(string $url, ?int $version = null): string
    {
        $version = $version ?? (int) @filemtime(public_path(parse_url($url, PHP_URL_PATH) ?? ''));
        $sep = str_contains($url, '?') ? '&' : '?';
        return $url . $sep . 'v=' . $version;
    }
}

if (!function_exists('fe_minify_html')) {
    function fe_minify_html(string $html): string
    {
        $html = preg_replace('/>\s+</', '><', $html);
        $html = preg_replace('/\s{2,}/', ' ', $html);
        return trim($html);
    }
}

?>


